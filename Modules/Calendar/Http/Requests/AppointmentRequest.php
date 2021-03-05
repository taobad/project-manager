<?php

namespace Modules\Calendar\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'venue'       => 'required',
            'start_time'  => 'required|date_format:' . config('system.preferred_date_format') . ' h:i A|after:now',
            'finish_time' => 'required|date_format:' . config('system.preferred_date_format') . ' h:i A|after_or_equal:start_time',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
