<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
    public function rules()
    {
        $userId = $this->user()?->id;
        $rules = [
            'payment_method' => 'required|in:cash,card,paypal',
        ];
        if (!$userId) {
            $rules['address.name'] = 'required|string';
            $rules['address.address_line'] = 'required|string';
            $rules['address.city'] = 'required|string';
            $rules['address.state'] = 'required|string';
            $rules['address.country'] = 'required|string';
            $rules['address.postal_code'] = 'nullable|string';
        } else {
            $rules['address_id'] = 'nullable|exists:addresses,id,user_id,' . $userId;
            $rules['address'] = 'required_without:address_id|array';
            $rules['address.street'] = 'required_if:address_id,null|string';
            $rules['address.city'] = 'required_if:address_id,null|string';
            $rules['address.state'] = 'required|string';
            $rules['address.country'] = 'required_if:address_id,null|string';
            $rules['address.postal_code'] = 'nullable|string';
        }
        return $rules;
    }
}
