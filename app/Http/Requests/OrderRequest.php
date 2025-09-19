<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,paypal,cash',
            'card_name' => 'required_if:payment_method,card|string|max:255',
            'card_number' => 'required_if:payment_method,card|string|max:20',
            'card_exp_month' => 'required_if:payment_method,card|string|size:2',
            'card_exp_year' => 'required_if:payment_method,card|string|size:4',
            'card_cvc' => 'required_if:payment_method,card|string|size:3',
            'discount_code' => 'nullable|string|max:50',
        ];
    }
}
