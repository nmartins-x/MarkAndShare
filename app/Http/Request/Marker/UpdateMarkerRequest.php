<?php

namespace App\Http\Request\Marker;

use \Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\User;
use App\Marker;

class UpdateMarkerRequest extends FormRequest {   
    /**
     * 
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required:numeric',
        ];
    }
    
    /**
     * Validates that user owns the Listing or marker and mutates the request 'is_approved' param
     * 
     * @param User $user
     * @param Marker $marker
     * @return bool
     */
    public function userIsApproved(User $user, Marker $marker): bool
    {
        // Validate that user owns the Listing or owns the Marker        
        if($user->listing()->find($marker->listing_id)){
            // do nothing
        } else if($marker->user_id == $user->id){
            // keep the state on the DB
            // only owners of a Listing can modify approve status
            $this->is_approved = $marker->is_approved;
        } else {
            return false;
        }
        
        return true;
    }
}

