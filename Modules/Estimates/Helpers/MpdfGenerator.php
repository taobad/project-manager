<?php

namespace Modules\Estimates\Helpers;

use App\Contracts\PDFCreatorInterface;
use PDF;

class MpdfGenerator implements PDFCreatorInterface
{
    public function pdf($model, $download)
    {
        $filename = langapp('estimate') . ' ' . $model->reference_no . '.pdf';
        $data['estimate'] = $model;
        $image = getStorageUrl(config('system.media_dir') . '/' . get_option('invoice_logo'));
        $data['logo'] = filter_var($image, FILTER_VALIDATE_URL) ? $image : config('app.url') . $image;
        $pdf = PDF::loadView('estimates::pdf.' . config('system.pdf.estimates.template'), $data);
        if ($download) {
            return $pdf->download($filename);
        }
        return $pdf->stream();
    }
}
