<?php

namespace App\Http\Request\Marker;

use \Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Marker;
use App\User;

class DestroyMarkerRequest extends FormRequest {
    public function authorize()
    {   
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
    
    /**
     * Validates required fields and if user is authorized, returning an error
     * 
     * @param Marker $marker
     * @param User $user
     * 
     * @return string
     */
    public function validateRequired(Marker $marker, User $user): string
    {
        if(!$marker->listing_id){
            return 'Error: listing_id is required';
        }
        
        try {
            $user->listing()->findOrFail($marker->listing_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex){
            return 'Not authorized.';
        }
        
        return '';
    }
}

