<?php

namespace Modules\Estimates\Helpers;

use App\Contracts\PDFCreatorInterface;
use App\Entities\Currency;
use PDF;
use Workice\PdfInvoice\InvoicePrinter;

class InvoicrGenerator implements PDFCreatorInterface
{
    public function pdf($model, $download)
    {
        \App::setLocale($model->company->locale);
        $filename = langapp('estimate') . ' ' . $model->reference_no . '.pdf';
        $cur = Currency::where('code', $model->currency)->first();
        $l = languageUsingLocale($model->company->locale);
        $image = getStorageUrl(config('system.media_dir') . '/' . get_option('invoice_logo'));
        $logo = filter_var($image, FILTER_VALIDATE_URL) ? $image : config('app.url') . $image;
        $estimate = new InvoicePrinter(null, $cur->native, $model->company->locale);

        $estimate->setLogo($logo);
        $estimate->setColor(get_option('estimate_color'));
        $estimate->setType(langapp('estimate'));
        $estimate->setReference($model->reference_no);
        $estimate->setNumberFormat($cur->decimal_sep, $cur->thousands_sep);
        $estimate->setDate(date('M dS, Y', strtotime($model->created_at)));
        if (config('system.pdf.estimates.show_bill_time')) {
            $estimate->setTime(date('h:i:s A', strtotime($model->created_at)));
        }
        $estimate->setDue(date('M dS, Y', strtotime($model->due_date)));
        if (settingEnabled('swap_to_from')) {
            $estimate->flipflop();
        }
        $estimate->setFrom(
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
        $estimate->setTo(
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
            $estimate->addItem(
                $item->name,
                $item->description,
                formatQuantity($item->quantity),
                $model->tax_per_item ? $item->tax_total : false,
                $item->unit_cost,
                $model->discount_per_item ? $item->discount : false,
                $item->total_cost
            );
        }

        $estimate->addTotal(langapp('total'), $model->subTotal());
        if ($model->discount > 0) {
            $estimate->addTotal(langapp('discount'), $model->discounted());
        }
        foreach ($model->taxes->groupBy('tax_type_id') as $taxes) {
            $estimate->addTotal($taxes[0]->taxtype->name . '(' . formatTax($taxes[0]->percent) . '%)', formatCurrency($model->currency, $model->taxTypeAmount($taxes)));
        }
        if ($model->tax != 0) {
            $estimate->addTotal(get_option('tax1Label') . '(' . formatTax($model->tax) . '%)', $model->tax1Amount());
        }
        if ($model->tax2 != 0) {
            $estimate->addTotal(get_option('tax2Label') . '(' . formatTax($model->tax2) . '%)', $model->tax2Amount());
        }

        $estimate->addTotal(langapp('amount'), $model->amount(), true);

        if (settingEnabled('display_estimate_badge')) {
            $estimate->addBadge($model->status);
        }

        if (settingEnabled('show_estimate_sign')) {
            $estimate->addParagraph(langapp('authorized_signature') . ' ...............................................................');
        }

        $estimate->addTitle(langapp('notes'));

        $estimate->addParagraph(strip_tags($model->notes));

        $estimate->setFooternote(strip_tags(get_option('estimate_footer')));

        if (!$download) {
            return $estimate->render($filename, 'S');
        }
        $estimate->render($filename, 'D');
    }
}
