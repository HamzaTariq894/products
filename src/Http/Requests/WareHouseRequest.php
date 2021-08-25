<?php

namespace Teamincredibles\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WareHouseRequest extends FormRequest
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
            'name' => 'required|string',
            'shop_id' => 'integer',
            'branch_id' => 'integer'
            ];
        if(strpos($this->path(),'edit/warehouse/details') !== false) {
            $rules += ['warehouse_id' => 'required|integer'];
        } else if(strpos($this->path(),'warehouse/delete') !== false) {
            unset($rules['name']);
            unset($rules['shop_id']);
            unset($rules['branch_id']);
            $rules += ['warehouse_id' => 'required|integer'];
        }
        return $rules;
    }
}
