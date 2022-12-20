<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class CadryRequest extends FormRequest
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
            'fullname' => 'required',
            'department_id' => 'required',
            'position_id' => 'required',
            'education_id' => 'required',
            'position_date' => 'required',
            'job_date' => 'required',
            'rail_date' => 'required',
            'birth_date' => 'required',
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
            'fullname.required' =>"Поле идентификатора ФИО обязательно.",
            'department_id.required' =>"Поле идентификатора Отдел обязательно.",
            'position_id.required' =>'Поле идентификатора Должность обязательно.',
            'education_id.required' =>'Поле идентификатора Образования обязательно.',
            'position_date.required' =>"Поле идентификатора Дата вступления в должность обязательно.",
            'job_date.required' =>"Поле идентификатора Дата приема на работу обязательно.",
            'rail_date.required' =>'Поле идентификатора Дата ЖД обязательно.',
            'birth_date.required' =>'Поле идентификатора Дата рождения обязательно.',
        ];
    }
}
