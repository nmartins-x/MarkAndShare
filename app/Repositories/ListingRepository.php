<?php

namespace App\Repositories;

use App\Listing;
use App\User;
use Illuminate\Database\Eloquent\Model;

Class ListingRepository {
    protected $model;
    
    public function __construct(Listing $model)
    {         
        $this->model = $model;
    }
    
     /**
     * get collection of items in paginate format.
     * 
     * @return Collection of items.
     */
    public function index(User $user)
    {
        $listing = $this->model::where('public_listed', 1);
        
        if ($user) {
            $listing = $listing->orWhere('user_id', $user->id);
        }
        
        $items = $listing->get();
        
        return $items;
    }
    
    public function user_owned(User $user)
    {     
        return $user->listing()->get();
    }
    
     /**
     * Retrieve a specific item
     */
    public function show(string $unique_url)
    {
        $listing = $this->model::where('unique_url', $unique_url);

        $item = $listing->first();
        
        return $item;
    }
    
    /**
     * Saves a resource in the database
     * 
     * @param object $listingData
     * @param User $user
     * 
     * @return Listing
     */
    public function create(object $listingData, User $user): Listing {
        // Generate an unique random string of 6 characters
        do {
            $unique_url = $this->randomStringGenerator(6);

            $url_exists = Listing::where('unique_url', $unique_url)->exists();
        } while ($url_exists);

        $listingData->merge([
            'user_id' => $user->id,
            'unique_url' => $unique_url
        ]);

        $listing = Listing::create($listingData->all());

        return $listing;
    }
    
    /**
     * Updates a resource in the database
     * 
     * @param int $id
     * @param object $listingData
     * 
     * @return Listing
     */
    public function update(int $id, object $listingData): Listing 
    {       
        $item = $this->model->findOrFail($id);
        
        $item->update(
            $listingData->only('name', 'description', 'public_listed')
        );

        return $item;
    }
    
    public function destroy(int $id)
    {         
        $this->model->destroy($id);
        
        // @todo remove all markers associated to the listing 
        
        return true;
    }
    
    /**
    * Retrieve markers associated to a listing
    */
    public function getMarkers(string $unique_url)
    {
        $listing = $this->model::where('unique_url', $unique_url)->first();

        $markers = $listing->markers;
        
        return $markers;
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
