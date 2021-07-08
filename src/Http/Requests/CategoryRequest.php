<?php

namespace Teamincredibles\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'owner_id' => 'required|integer'
            ];
        if(strpos($this->path(),'edit/category/details') !== false) {
            $rules += ['category_id' => 'required|integer'];
            unset($rules['owner_id']);
        } else if(strpos($this->path(),'category/delete') !== false) {
            unset($rules['name']);
            unset($rules['owner_id']);
            $rules += ['category_id' => 'required|integer'];
        }
        return $rules;
    }
}
