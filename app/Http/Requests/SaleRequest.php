<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'total'                         => [ 'required', 'decimal:0,2' ],
            'cash_tendered'                 => [ 'required', 'decimal:0,2' ],
            'change'                        => [ 'required', 'decimal:0,2' ],
            'purchase_list'                 => [ 'required', 'array', 'min:1' ],
            'purchase_list.*.id'            => [ 'required', 'integer', 'exists:products,id' ],
            'purchase_list.*.name'          => [ 'required', 'string' ],
            'purchase_list.*.description'   => [ 'nullable', 'string' ],
            'purchase_list.*.selling_price' => [ 'required', 'decimal:0,2' ],
            'purchase_list.*.quantity'      => [ 'required', 'integer', 'min:1' ],
            'purchase_list.*.sub_total'     => [ 'required', 'decimal:0,2' ],
        ];
    }
}
