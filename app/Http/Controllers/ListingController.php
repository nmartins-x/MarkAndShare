<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use App\Http\Request\Listing\StoreListingRequest;
use App\Http\Request\Listing\UpdateListingRequest;
use App\Http\Request\Listing\DestroyListingRequest;
use Illuminate\Http\Response;
use App\Repositories\ListingRepository;
use Auth;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Validator;

class ListingController {
    protected $repository;
  
    public function __construct(ListingRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function index()
    {
        $listings = $this->repository->index(Auth::User());
  
        return response($listings, 201);
    }
    
    public function user_owned()
    {   
        $listing = $this->repository->user_owned(Auth::User());
        
        return response($listing, 201);
    }
    
    public function show(string $unique_url)
    {
        $listing = $this->repository->show($unique_url);

        return response(json_encode($listing), 201);
    }

    /**
     * Store resource to database
     * 
     * @param StoreListingRequest $request
     * @param ListingRepository $listingRepository
     * @return Response
     */
    public function store(StoreListingRequest $request): Response
    {           
        $listing = $this->repository->create($request, Auth::User());

        return response($listing, 201);
    }

    public function update(int $id, UpdateListingRequest $request)
    {
        $listing = $this->repository->update($id, $request);

        return response()->json($listing);
    }
    
    public function destroy($id, DestroyListingRequest $request)
    {        
        $destroy = $this->repository->destroy($id);
        
        return response()->json(['result' => 'deleted']);
    }
    
    public function getMarkers(string $unique_url)
    {
        $markers = $this->repository->getMarkers($unique_url);

        return response(json_encode($markers), 201);
    }

}
