<?php

namespace App\Traits;

trait AjaxResponse
{
    protected function success($data, $success = true, $code = 200)
    {
        $data['success'] = $success;
        return response()->json($data, $code);
    }

    protected function failure($data, $success = false, $code = 500)
    {
        $errors = empty($data['errors']) ? ['Request failed please try again'] : $data['errors'];
        $data['errors'] = array($errors);
        $data['success'] = $success;
        return response()->json($data, $code);
    }
}
