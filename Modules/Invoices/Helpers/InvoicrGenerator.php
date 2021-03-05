<?php

namespace Modules\Invoices\Helpers;

use App\Contracts\PDFCreatorInterface;
use App\Entities\Currency;
use PDF;
use Workice\PdfInvoice\InvoicePrinter;

class InvoicrGenerator implements PDFCreatorInterface
{
    public function pdf($model, $download)
    {
        \App::setLocale($model->company->locale);
        $filename = langapp('invoice') . ' ' . $model->reference_no . '.pdf';
        $cur = Currency::where('code', $model->currency)->first();
        $l = languageUsingLocale($model->company->locale);
        if (config('filesystems.default') == 'local') {
            $logo = '../storage/app/public/media/' . get_option('invoice_logo');
        } else {
            $image = getStorageUrl(config('system.media_dir') . '/' . get_option('invoice_logo'));
            $logo = filter_var($image, FILTER_VALIDATE_URL) ? $image : config('app.url') . $image;
        }

        $invoice = new InvoicePrinter(null, $cur->native, $model->company->locale);
        $invoice->setLogo($logo);
        $invoice->setColor(get_option('invoice_color'));
        $invoice->setType(langapp('invoice'));
        $invoice->setReference($model->reference_no);
        $invoice->setNumberFormat($cur->decimal_sep, $cur->thousands_sep, $cur->symbol_left ? 'left' : 'right', $cur->space_between ? true : false);
        $invoice->setDate(date('M dS, Y', strtotime($model->created_at)));
        if (config('system.pdf.invoices.show_bill_time')) {
            $invoice->setTime(date('h:i:s A', strtotime($model->created_at)));
        }
        $invoice->setDue(date('M dS, Y', strtotime($model->due_date)));
        if (settingEnabled('swap_to_from')) {
            $invoice->flipflop();
        }
        $invoice->setFrom(
            array(
                get_option('company_name'),
                (get_option('company_legal_name_' . $l) ? get_option('company_legal_name_' . $l) : get_option('company_legal_name')),
                (get_option('company_address_' . $l) ? get_option('company_address_' . $l) : get_option('company_address')),
                (get_option('company_city_' . $l) ? get_option('company_city_' . $l) : get_option('company_city')) . ', ' . (get_option('company_state_' . $l) ? get_option('company_state_' . $l) : get_option('company_state')) . ' ' .
                (get_option('company_zip_code_' . $l) ? get_option('company_zip_code_' . $l) : get_option('company_zip_code')),
                (get_option('company_country_' . $l) ? get_option('company_country_' . $l) : get_option('company_country')),
                langapp('phone_short') . (get_option('company_phone_' . $l) ? get_option('company_phone_' . $l) : get_option('company_phone')),
                settingEnabled('show_tax_number') ? langapp('tax_number') . ':' . (get_option('company_vat_' . $l) ? get_option('company_vat_' . $l) : get_option('company_vat')) : false,
            )
        );
        $address = $model->billing_city . ', ';
        $address .= $model->billing_state != '' ? $model->billing_state . ' ' : ' ';
        $address .= $model->billing_zip != '' ? $model->billing_zip : ' ';
        $invoice->setTo(
            array(
                $model->company->name,
                $model->company->name,
                $model->billing_street . ',',
                $address,
                $model->billing_country,
                langapp('phone_short') . $model->company->phone,
                settingEnabled('show_tax_number') ? langapp('tax_number') . ':' . $model->company->tax_number : false,
            )
        );
        foreach ($model->items as $item) {
            $invoice->addItem(
                $item->name,
                $item->description,
                (float) $item->quantity,
                $model->tax_per_item ? $item->tax_total : false,
                (float) $item->unit_cost,
                $model->discount_per_item ? $item->discount : false,
                (float) $item->total_cost
            );
        }

        $invoice->addTotal(langapp('total'), $model->subTotal());
        if ($model->discount > 0) {
            $invoice->addTotal(langapp('discount'), (float) $model->discounted());
        }
        foreach ($model->taxes->groupBy('tax_type_id') as $taxes) {
            $invoice->addTotal($taxes[0]->taxtype->name . '(' . formatTax($taxes[0]->percent) . '%)', formatCurrency($model->currency, $model->taxTypeAmount($taxes)));
        }
        if ($model->tax != 0) {
            $invoice->addTotal(get_option('tax1Label') . '(' . formatTax($model->tax) . '%)', $model->tax1Amount());
        }
        if ($model->tax2 != 0) {
            $invoice->addTotal(get_option('tax2Label') . '(' . formatTax($model->tax2) . '%)', $model->tax2Amount());
        }

        if ($model->lateFee() > 0) {
            $invoice->addTotal(langapp('late_fee'), $model->lateFee());
        }
        if ($model->extra_fee > 0) {
            $invoice->addTotal(langapp('extra_fee') . '(' . formatDecimal($model->extra_fee) . '%)', $model->extraFee());
        }
        if ($model->paid() > 0) {
            $invoice->addTotal(langapp('payment_made'), $model->paid());
        }
        if ($model->creditedAmount() > 0) {
            $invoice->addTotal(langapp('credits_applied'), $model->creditedAmount());
        }

        $invoice->addTotal(langapp('balance_due'), $model->due(), true);

        if (settingEnabled('display_invoice_badge')) {
            $invoice->addBadge($model->status);
        }
        if (settingEnabled('show_invoice_sign')) {
            $invoice->addParagraph(langapp('authorized_signature') . ' ...............................................................');
        }
        if ($model->gatewayEnabled('bank') && settingEnabled('bank_on_invoice_pdf')) {
            $invoice->addTitle(langapp('bank_details'));
            $invoice->addParagraph(nl2br(strip_tags(get_option('bank_details'))));
        }
        $invoice->addTitle(langapp('payment_information'));

        $invoice->addParagraph(strip_tags($model->notes));

        $invoice->setFooternote(strip_tags(get_option('invoice_footer')));

        if (!$download) {
            return $invoice->render($filename, 'S');
        }
        $invoice->render($filename, 'D');
    }
}
