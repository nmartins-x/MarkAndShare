<?php

namespace App\Http\Request\Marker;

use \Illuminate\Foundation\Http\FormRequest;

class StoreMarkerRequest extends FormRequest {
    /**
     * 
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'description' => 'max:1000',
            'lgt' => 'required',
            'lat' => 'required',
        ];
    }
}

