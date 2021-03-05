<?php

namespace Modules\Contracts\Helpers;

use App\Contracts\PDFCreatorInterface;
use PDF;

class InvoicrGenerator implements PDFCreatorInterface
{
    public function pdf($model, $download)
    {
        $filename = langapp('contract') . ' ' . $model->contract_title . '.pdf';
        $data['contract'] = $model;
        $data['sign'] = true;
        $clientSignature = 'storage/signatures/' . optional($model->clientSign)->image;
        $data['clientSignature'] = filter_var($clientSignature, FILTER_VALIDATE_URL) ? $clientSignature : config('app.url') . '/' . $clientSignature;

        $contractorSignature = 'storage/signatures/' . optional($model->contractorSign)->image;
        $data['contractorSignature'] = filter_var($contractorSignature, FILTER_VALIDATE_URL) ? $contractorSignature : config('app.url') . '/' . $contractorSignature;

        $pdf = PDF::loadView('contracts::pdf.contract', $data);
        if ($download) {
            return $pdf->download($filename);
        }
        return $pdf->stream();
    }
}
