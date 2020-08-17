<?php

namespace App\Repositories;

use App\Marker;
use App\User;

Class MarkerRepository {
    /** @var type */
    protected $model;
    
    /** 
     * @param Marker $model
     */
    public function __construct(Marker $model)
    {         
        $this->model = $model;
    }
    
     /**
     * Retrieve a specific item
     */
    public function show(string $id): Marker
    {
        $marker = $this->model::find($id);
        
        return $marker;
    }
    
    /**
     * Saves a resource in the database
     * 
     * @param object $markerData
     * @param User $user
     * @param \App\Listing $listing
     * 
     * @return Marker
     */
    public function create(object $markerData, User $user, \App\Listing $listing): Marker
    {
        $markerData->merge([
            'user_id' => $user->id,
            'listing_id' => $listing->id,
            'is_approved' => ($listing->user_id == $user->id ? 1 : 0),
        ]);

        $marker = Marker::create($markerData->all());

        return $marker;
    }
    
    /**
     * Updates a resource in the database
     * 
     * @param int $id
     * @param object $markerData
     * 
     * @return Marker
     */
    public function update(int $id, object $markerData): Marker 
    {       
        $item = $this->model->findOrFail($id);
        
        $item->update(
            $markerData->only('name', 'description', 'is_approved', 'lgt', 'lat')
        );

        return $item;
    }
    
    /**
     * Removes one resource from database
     * 
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {         
        $this->model->destroy($id);
        
        return true;
    }

}
