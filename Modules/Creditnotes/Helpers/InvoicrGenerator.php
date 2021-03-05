<?php

namespace Modules\Creditnotes\Helpers;

use App\Contracts\PDFCreatorInterface;
use App\Entities\Currency;
use PDF;
use Workice\PdfInvoice\InvoicePrinter;

class InvoicrGenerator implements PDFCreatorInterface
{
    public function pdf($model, $download)
    {
        \App::setLocale($model->company->locale);
        $filename = langapp('credit_note') . ' ' . $model->reference_no . '.pdf';
        $cur = Currency::where('code', $model->currency)->first();
        $l = languageUsingLocale($model->company->locale);
        $image = getStorageUrl(config('system.media_dir') . '/' . get_option('invoice_logo'));
        $logo = filter_var($image, FILTER_VALIDATE_URL) ? $image : config('app.url') . $image;
        $creditnote = new InvoicePrinter(null, $cur->native, $model->company->locale);

        $creditnote->setLogo($logo);
        $creditnote->setColor(get_option('creditnote_color'));
        $creditnote->setType(langapp('credit_note'));
        $creditnote->setReference($model->reference_no);
        $creditnote->setNumberFormat($cur->decimal_sep, $cur->thousands_sep);
        $creditnote->setDate(date('M dS, Y', strtotime($model->created_at)));
        if (config('system.pdf.credits.show_bill_time')) {
            $creditnote->setTime(date('h:i:s A', strtotime($model->created_at)));
        }
        if (settingEnabled('swap_to_from')) {
            $creditnote->flipflop();
        }
        $creditnote->setFrom(
            array(
                get_option('company_name'),
                (get_option('company_legal_name_' . $l) ? get_option('company_legal_name_' . $l) : get_option('company_legal_name')),
                (get_option('company_address_' . $l) ? get_option('company_address_' . $l) : get_option('company_address')),
                (get_option('company_city_' . $l) ? get_option('company_city_' . $l) : get_option('company_city')) . ', ' . (get_option('company_state_' . $l) ? get_option('company_state_' . $l) : get_option('company_state')) . ' ' .
                (get_option('company_zip_code_' . $l) ? get_option('company_zip_code_' . $l) : get_option('company_zip_code')),
                (get_option('company_country_' . $l) ? get_option('company_country_' . $l) : get_option('company_country')),
                langapp('phone') . ':' . (get_option('company_phone_' . $l) ? get_option('company_phone_' . $l) : get_option('company_phone')),
                langapp('tax_number') . ':' . (get_option('company_vat_' . $l) ? get_option('company_vat_' . $l) : get_option('company_vat')),
            )
        );
        $address = $model->billing_city . ', ';
        $address .= $model->billing_state != '' ? $model->billing_state . ' ' : ' ';
        $address .= $model->billing_zip != '' ? $model->billing_zip : ' ';
        $creditnote->setTo(
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
            $creditnote->addItem(
                $item->name,
                $item->description,
                formatQuantity($item->quantity),
                $model->tax_per_item ? $item->tax_total : false,
                $item->unit_cost,
                false,
                $item->total_cost
            );
        }

        $creditnote->addTotal(langapp('total'), $model->subTotal());
        foreach ($model->taxes->groupBy('tax_type_id') as $taxes) {
            $creditnote->addTotal($taxes[0]->taxtype->name . '(' . formatTax($taxes[0]->percent) . '%)', formatCurrency($model->currency, $model->taxTypeAmount($taxes)));
        }
        if ($model->tax > 0) {
            $creditnote->addTotal(langapp('tax') . '(' . formatTax($model->tax) . '%)', $model->tax());
        }
        if ($model->usedCredits() > 0) {
            $creditnote->addTotal(langapp('credits_used'), $model->usedCredits());
        }

        $creditnote->addTotal(langapp('balance'), $model->balance(), true);

        $creditnote->addBadge($model->status);

        if (settingEnabled('show_creditnote_sign')) {
            $creditnote->addParagraph(langapp('authorized_signature') . ' ...............................................................');
        }

        $creditnote->addTitle(langapp('notes'));

        $creditnote->addParagraph(strip_tags($model->terms));

        $creditnote->setFooternote(strip_tags(get_option('creditnote_footer')));

        if (!$download) {
            return $creditnote->render($filename, 'S');
        }
        $creditnote->render($filename, 'D');
    }
}
