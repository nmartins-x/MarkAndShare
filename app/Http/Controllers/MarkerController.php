<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marker;
use App\Listing;
use Illuminate\Http\Response;
use Auth;

class MarkerController extends Controller
{
    public function store(Request $request) {      
        request()->validate([
            'name' => 'required|max:100',
            'description' => 'max:1000',
            'lgt' => 'required',
            'lat' => 'required',
        ]);
        
        $listing = Listing::where('id', $request->listing_id)->first();
         
        $user = Auth::User();

        $request->merge([
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'is_approved' => ($listing->user_id == $user->id ? 1 : 0),
        ]);

        $response = Marker::create($request->all());

        return response($response, 201);
    }

    public function update(Request $request, Marker $marker) {
        request()->validate([
            'id' => 'required:numeric',
        ]);
        
        $marker = Marker::findOrFail($marker->id);
        
        $user = Auth::User();
        
        // Validate that user owns the Listing or owns the Marker        
        if($user->listing()->find($marker->listing_id)){
            // do nothing
        } else if($marker->user_id == $user->id){
            // keep the state on the DB
            // only owners of a Listing can modify approve status
            $request->is_approved = $marker->is_approved;
        } else {
            return response([], 401);
        }

        $marker->update(
            $request->only('name', 'description', 'is_approved', 'lgt', 'lat')
        );

        return response()->json($marker);
    }
    
    public function destroy(Marker $marker)
    {
        if(!$marker->id) {
            return response('Error: id is required', 400);
        } else if(!$marker->listing_id){
            return response('Error: listing_id is required', 400);
        }
        
        $user = Auth::User();       
        $user->listing()->findOrFail($marker->listing_id);
        
        $marker->delete();
        
        return response()->json(['result' => 'deleted']);
    }
}
