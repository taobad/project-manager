<?php

namespace Modules\Tasks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'              => 'numeric',
            'project_id'      => 'required|numeric',
            'name'            => 'required',
            'milestone_id'    => 'sometimes|numeric',
            'progress'        => 'numeric',
            'start_date'      => 'required|date_format:' . config('system.preferred_date_format'),
            'due_date'        => 'required|date_format:' . config('system.preferred_date_format') . '|after_or_equal:start_date',
            'estimated_hours' => 'numeric',
            'hourly_rate'     => 'numeric',
        ];
    }
}
