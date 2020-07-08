<?php

namespace App\Http\Controllers;

use App\Http\Request\Listing\StoreListingRequest;
use App\Http\Request\Listing\UpdateListingRequest;
use App\Http\Request\Listing\DestroyListingRequest;
use Illuminate\Http\Response;
use App\Repositories\ListingRepository;
use Auth;

class ListingController {
    /** @var type */
    protected $repository;
  
    /**
     * @param ListingRepository $repository
     */
    public function __construct(ListingRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Retrieve all listings
     * 
     * @return Response
     */
    public function index(): Response
    {
        $listings = $this->repository->index(Auth::User());
  
        return response($listings, 201);
    }
    
    /**
     * Retrieve all listings owned by the authenticated user
     * 
     * @return Response
     */
    public function user_owned(): Response
    {   
        $listing = $this->repository->user_owned(Auth::User());
        
        return response($listing, 201);
    }
    
    /**
     * Shows all data associated to one listing
     * 
     * @param string $unique_url
     * @return Response
     */
    public function show(string $unique_url): Response
    {
        $listing = $this->repository->show($unique_url);

        return response(json_encode($listing), 201);
    }

    /**
     * Store resource to database
     * 
     * @param StoreListingRequest $request
     * @return Response
     */
    public function store(StoreListingRequest $request): Response
    {           
        $listing = $this->repository->create($request, Auth::User());

        return response($listing, 201);
    }

    /**
     * Updates a listing
     * 
     * @param int $id
     * @param UpdateListingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, UpdateListingRequest $request): \Illuminate\Http\JsonResponse
    {
        $listing = $this->repository->update($id, $request);

        return response()->json($listing);
    }
    
    /**
     * Destroys one listing
     * 
     * @param type $id
     * @param DestroyListingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, DestroyListingRequest $request): \Illuminate\Http\JsonResponse
    {        
        $destroy = $this->repository->destroy($id);
        
        return response()->json(['result' => 'deleted']);
    }
    
    /**
     * Retrieves all markers associated to a listing
     * 
     * @param string $unique_url
     * @return Response
     */
    public function getMarkers(string $unique_url): Response
    {
        $markers = $this->repository->getMarkers($unique_url);

        return response(json_encode($markers), 201);
    }

}
