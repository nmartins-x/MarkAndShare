<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Validator;

class ListingController {    
    public function index()
    {
        $listing = Listing::where('public_listed', 1);
        
        if ($user = Auth::User()) {
            $listing = $listing->orWhere('user_id', $user->id);
        }
        
        $response = $listing->get();
  
        return response($response, 201);
    }
    
    public function user_owned()
    {   
        $user = Auth::User();
                
        $listings = $user->listing()->get();
  
        return response($listings, 201);
    }
    
    public function show(string $unique_url)
    {
        $listing = Listing::where('unique_url', $unique_url);

        $response = $listing->first();

        return response(json_encode($response), 201);
    }

    public function store(Request $request) {
        request()->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
            'public_listed' => 'required|boolean'
        ]);
        
        $user = Auth::User();

        // Generate an unique random string of 6 characters
        do {
            $unique_url = $this->randomStringGenerator(6);

            $url_exists = Listing::where('unique_url', $unique_url)->exists();
        } while ($url_exists);

        $request->merge([
            'user_id' => $user->id,
            'unique_url' => $unique_url
        ]);

        $response = Listing::create($request->all());

        return response($response, 201);
    }

    public function update(Request $request, Listing $listing) {
        request()->validate([
            'id' => 'required:numeric',
        ]);
        
        $user = Auth::User();
        
        // Validate that user owns the Listing
        $user->listing()->findOrFail($request->id);

        $listing->update(
            $request->only('name', 'description', 'public_listed')
        );

        return response()->json($listing);
    }
    
    public function destroy(Listing $listing)
    {
        if(!$listing->id) {
            return response('Error: id is required', 400);
        }
        
        $user = Auth::User();
        
        $user->listing()->findOrFail($listing->id);
        
        $listing->delete();
        
        return response()->json(['result' => 'deleted']);
    }

    /**
     * Generates a random string of letters
     * 
     * @param int $len
     * @return string
     */
    protected function randomStringGenerator(int $len): string {
        $base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz';
        $max = strlen($base) - 1;
        $activatecode = '';

        mt_srand((double) microtime() * 1000000);

        while (strlen($activatecode) < $len)
            $activatecode .= $base{mt_rand(0, $max)};

        return $activatecode;
    }

}
