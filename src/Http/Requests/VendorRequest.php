<?php

namespace Teamincredibles\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'vendor_name' => 'required|string',
            'owner_id' => 'required|integer'
            ];
        if(strpos($this->path(),'edit/vendor/details') !== false) {
            $rules += ['vendor_id' => 'required|integer'];
        } else if(strpos($this->path(),'vendor/delete') !== false) {
            unset($rules['vendor_name']);
            unset($rules['owner_id']);
            $rules += ['vendor_id' => 'required|integer'];
        }
        return $rules;
    }
}
