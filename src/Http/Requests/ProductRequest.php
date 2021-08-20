<?php

namespace Teamincredibles\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code' => 'required|integer',
            'owner_id' => 'required|integer',
            'vendor_id' => 'required|integer',
            "category_ids"    => "required|array",
            "category_ids.*"  => "required|integer",
            'description' => 'nullable|string',
            'measurement_unit_id' =>'required|integer',
            'purchase_rate' => 'required|numeric',
            'sale_rate' => 'required|numeric',
            'dealer_sale_price' => 'required|numeric',
            'wholesale_sale_price' => 'required|numeric',
            'retailer_sale_price' => 'required|numeric',
            'vendor_name' => 'required|string',
            'description' => 'required|string'
            ];
        if(strpos($this->path(),'add/product') !== false){
            $rules += ['branch_id' => 'required|integer'];
            if($this->request->get('vendor_id')) {
                unset($rules['vendor_name']);
            } else if($this->request->get('vendor_name')) {
                unset($rules['vendor_id']);
            } else if(!$this->request->get('vendor_id') && !$this->request->get('vendor_name')) {
                $rules += ['vendor_id' => 'required|integer'];
            }
        }
        if(strpos($this->path(),'add/product/rates') !== false) {
            unset($rules['code']);
            unset($rules['owner_id']);
            unset($rules['vendor_id']);
            unset($rules["category_ids"]);
            unset($rules["category_ids.*"]);
            unset($rules['description']);
            unset($rules['measurement_unit_id']);
            unset($rules['warehouse_id']);
            $rules += ['product_id' => 'required|integer'];
            $rules += ['branch_id' => 'required|integer'];
            $rules += ['rate_id' => 'required|integer'];
            $rules += ['purchase_rate' => 'required|numeric'];
            $rules += ['sale_rate' => 'required|numeric'];
            $rules += ['dealer_sale_price' => 'required|numeric'];
            $rules += ['wholesale_sale_price' => 'required|numeric'];
            $rules += ['retailer_sale_price' => 'required|numeric'];
        } else if(strpos($this->path(),'edit/product/details') !== false) {
            unset($rules['purchase_rate']);
            unset($rules['vendor_name']);
            unset($rules['sale_rate']);
            unset($rules['dealer_sale_price']);
            unset($rules['wholesale_sale_price']);
            unset($rules['retailer_sale_price']);
            unset($rules['code']);
            unset($rules['owner_id']);
            unset($rules['vendor_id']);
            unset($rules["category_ids"]);
            unset($rules["category_ids.*"]);
            $rules += ['product_id' => 'required|integer'];
        } else if(strpos($this->path(),'edit/product/rates') !== false) {
            unset($rules['code']);
            unset($rules['owner_id']);
            unset($rules['vendor_id']);
            unset($rules["category_ids"]);
            unset($rules["category_ids.*"]);
            unset($rules['description']);
            unset($rules['measurement_unit_id']);
            unset($rules['warehouse_id']);
            unset($rules['description']);
            $rules += ['product_id' => 'required|integer'];
            $rules += ['rate_id' => 'required|integer'];
            $rules += ['purchase_rate' => 'required|numeric'];
            $rules += ['sale_rate' => 'required|numeric'];
            $rules += ['dealer_sale_price' => 'required|numeric'];
            $rules += ['wholesale_sale_price' => 'required|numeric'];
            $rules += ['retailer_sale_price' => 'required|numeric'];
            $rules += ['branch_id' => 'required|integer'];
        }
        return $rules;
    }
}
