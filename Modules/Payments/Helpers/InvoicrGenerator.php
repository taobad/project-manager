<?php

namespace Modules\Payments\Helpers;

use App\Contracts\PDFCreatorInterface;
use App\Entities\Currency;
use PDF;
use Workice\PdfInvoice\InvoicePrinter;

class InvoicrGenerator implements PDFCreatorInterface
{
    public function pdf($model, $download)
    {
        \App::setLocale($model->company->locale);
        $filename = langapp('payment') . ' ' . $model->code . '.pdf';
        $cur = Currency::where('code', $model->currency)->first();
        $l = languageUsingLocale($model->company->locale);
        $image = getStorageUrl(config('system.media_dir') . '/' . get_option('invoice_logo'));
        $logo = filter_var($image, FILTER_VALIDATE_URL) ? $image : config('app.url') . $image;
        $payment = new InvoicePrinter(null, $cur->native, $model->company->locale);

        $payment->setLogo($logo);
        $payment->setColor(get_option('payment_color'));
        $payment->setType(langapp('payment'));
        $payment->setReference($model->code);
        $payment->setNumberFormat($cur->decimal_sep, $cur->thousands_sep);
        $payment->setDate(date('M dS, Y', strtotime($model->payment_date)));
        $payment->setTime(date('h:i:s A', strtotime($model->payment_date)));
        if (settingEnabled('swap_to_from')) {
            $payment->flipflop();
        }
        $payment->setFrom(
            array(
                get_option('company_name'),
                (get_option('company_legal_name_' . $l) ? get_option('company_legal_name_' . $l) : get_option('company_legal_name')),
                (get_option('company_address_' . $l) ? get_option('company_address_' . $l) : get_option('company_address')),
                (get_option('company_city_' . $l) ? get_option('company_city_' . $l) : get_option('company_city')) . ', ' . (get_option('company_state_' . $l) ? get_option('company_state_' . $l) : get_option('company_state')) . ' ' .
                (get_option('company_zip_code_' . $l) ? get_option('company_zip_code_' . $l) : get_option('company_zip_code')),
                (get_option('company_country_' . $l) ? get_option('company_country_' . $l) : get_option('company_country')),
                langapp('phone_short') . (get_option('company_phone_' . $l) ? get_option('company_phone_' . $l) : get_option('company_phone')),
                langapp('tax_number') . ':' . (get_option('company_vat_' . $l) ? get_option('company_vat_' . $l) : get_option('company_vat')),
            )
        );
        $address = $model->company->billing_city . ', ';
        $address .= $model->company->billing_state != '' ? $model->company->billing_state . ' ' : ' ';
        $address .= $model->company->billing_zip != '' ? $model->company->billing_zip : ' ';
        $payment->setTo(
            array(
                $model->company->name,
                $model->company->name,
                $model->company->billing_street . ',',
                $address,
                $model->company->billing_country,
                langapp('phone_short') . $model->company->phone,
                settingEnabled('show_tax_number') ? langapp('tax_number') . ':' . $model->company->tax_number : false,
            )
        );

        $payment->addItem(
            'Payment for Invoice #' . $model->AsInvoice->reference_no,
            nl2br(langapp('invoice_amount') . ': ' . formatCurrency($model->AsInvoice->currency, $model->AsInvoice->payable())) . '<br/>' . langapp('balance') . ': ' . formatCurrency($model->AsInvoice->currency, $model->AsInvoice->due()),
            formatQuantity(1),
            false,
            $model->amount,
            false,
            $model->amount
        );

        $payment->addTotal(langapp('paid'), $model->amount, true);

        $payment->addBadge($model->paymentMethod->method_name);

        $payment->addTitle(langapp('payment_information'));

        $payment->addParagraph(strip_tags($model->notes));

        $payment->setFooternote(strip_tags(get_option('company_name')));

        if (!$download) {
            return $payment->render($filename, 'S');
        }
        $payment->render($filename, 'D');
    }
}
