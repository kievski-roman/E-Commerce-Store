<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            //
            'name' => 'required|string|between:2,100',
            'price' => 'required|integer|between:1,1000000',
            'quantity' => 'required|integer|between:1,1000000',
            'description' => 'required|string|between:5,1999',
            'category_id' => 'required|integer|between:1,1000000',
            'image' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ];
    }
}
