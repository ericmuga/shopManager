<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'type'=>'required',
            'code'=>['required','unique:items,code'],
            'barcode'=>['unique:items,barcode'],
            'description'=>['required','unique:items,description'],
            'sales_uom'=>'required',
            'base_uom'=>'required',
            'unit_price'=>'required',
            'unit_cost'=>'required',
            'item_posting_group_id'=>'required',
            'tax_posting_group_id'=>'required',

        ];
    }
}
