<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewTransactionRequest extends FormRequest
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
            'payer' => 'required|integer',
            'payee' => 'required|integer',
            'value' => 'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'payer.required' => 'The payer field is required',
            'payer.integer'  => 'The payer field must be a integer value',
            'payee.required' => 'The payee field is required',
            'payee.integer'  => 'The payee field must be a integer value',
            'value.required' => 'The value field is required',
            'value.numeric'  => 'The value field must be a float value'
        ];
    }

}
