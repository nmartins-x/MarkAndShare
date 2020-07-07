<?php

namespace App\Http\Request\Listing;

use \Illuminate\Foundation\Http\FormRequest;
use Auth;

class DestroyListingRequest extends FormRequest {
    public function authorize()
    {   
        $listingId = $this->route('listing');
        
        $user = Auth::User();
        
        // Validate that user owns the Listing
        $user->listing()->findOrFail($listingId);
        
        return true;
    }
    
    /**
     * 
     * @return array
     */
    public function rules(): array
    {
        return [
        ];
    }
}

