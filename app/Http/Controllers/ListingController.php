<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Faker\Generator as Faker;

class ListingController {

    protected $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function store(Request $request) {
        do {
            $unique_url = $this->randomStringGenerator(6);
            
            $url_exists = Listing::where('unique_url', $unique_url)->exists();
        } while ($url_exists);
        
        $request->merge([
            'user_id' => $this->user->id,
            'unique_url' => $unique_url
        ]);

        $response = Listing::create($request->all());

        return response($response, 201);
    }
    
    /**
     * Generates a random string of letters
     * 
     * @param int $len
     * @return string
     */
    protected function randomStringGenerator(int $len):string {
        $base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz';
        $max = strlen($base) - 1;
        $activatecode = '';
        
        mt_srand((double) microtime() * 1000000);
        
        while (strlen($activatecode) < $len + 1)
            $activatecode .= $base{mt_rand(0, $max)};
            
        return $activatecode;
    }

}
