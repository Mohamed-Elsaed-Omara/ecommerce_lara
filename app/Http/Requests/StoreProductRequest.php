<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'required',
            'product_name' => 'required',
            'price' => 'numeric|between:0,999999.99',
            'description' => 'required',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate file type and size 
        ];
    }

    public function messages(): array
    {
        return [

            'category_id.required' => 'The category name field is required',
        ];
    }
}
