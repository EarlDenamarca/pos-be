<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name'          => [ 'required', 'unique:products' ],
            'category_id'   => [ 'required', 'integer' ],
            'price'         => [ 'required', 'decimal:0,2' ],
            'mark_up'       => [ 'required', 'numeric' ],
            'selling_price' => [ 'required', 'decimal:0,2' ],
        ];
    }
}
