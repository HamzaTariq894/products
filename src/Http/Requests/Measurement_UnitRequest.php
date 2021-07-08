<?php

namespace Teamincredibles\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Measurement_UnitRequest extends FormRequest
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
            ];
        if(strpos($this->path(),'edit/measurementunit/details') !== false) {
            $rules += ['measurementunit_id' => 'required|integer'];
        } else if(strpos($this->path(),'delete/measurementunit') !== false) {
            unset($rules['name']);
            $rules += ['measurementunit_id' => 'required|integer'];
        }
        return $rules;
    }
}
