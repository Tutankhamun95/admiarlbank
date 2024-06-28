<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:10.00',
            'toAccount' => 'required|exists:accounts,account_number'
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Sending nothing? Try sending some money',
            'amount.integer' => 'The amount must be a fucking number.',
            'toAccount.required' => 'Sending this to nobody?',
            'toAccount.exists' => 'Who the fuck is that?'
        ];
    }
}
