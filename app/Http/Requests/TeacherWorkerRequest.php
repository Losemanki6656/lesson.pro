<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class TeacherWorkerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'teacher_id' => 'required',
             'worker_id' => 'required',
             'from_date' => 'required',
             'to_date' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'teacher_id.required' =>"Поле идентификатора Учителя обязательно.",
            'worker_id.required' =>"Поле идентификатора Ученика обязательно.",
            'from_date.required' =>'Поле идентификатора Дата контракта обязательно.',
            'to_date.required' =>'Поле идентификатора Дата окончания контракта обязательно.'
        ];
    }
}
