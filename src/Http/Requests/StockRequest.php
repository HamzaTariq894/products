<?php

namespace Teamincredibles\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
        $rules = [
            'product_id' => 'required|integer',
            'branch_id' => 'required|integer',
            'name' => 'nullable|string',
            'quantity' => 'required|integer',
            'preferred_vendor' => 'sometimes|integer',
            'min_stock_level' => 'nullable|integer',
            'max_stock_level' => 'nullable|integer',
            'reorder_quantity' =>'nullable|integer',
            'rack_no' => 'nullable|integer',
            'opening_stock' => 'nullable|integer',
        ];
        if(strpos($this->path(),'edit/product/stock') !== false) {
            unset($rules['product_id']);
            unset($rules['branch_id']);
            $rules += ['stock_id' => 'required|integer'];
        }
        return $rules;
    }
}
