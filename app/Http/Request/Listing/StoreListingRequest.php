<?php

namespace App\Http\Request\Listing;

use \Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest {
    /**
     * 
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
            'public_listed' => 'required|boolean'
        ];
    }
}

