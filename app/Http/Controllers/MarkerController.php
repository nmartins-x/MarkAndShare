<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marker;
use App\Listing;
use Illuminate\Http\Response;
use Auth;
use App\Http\Request\Marker\StoreMarkerRequest;
use App\Http\Request\Marker\UpdateMarkerRequest;
use App\Http\Request\Marker\DestroyMarkerRequest;
use App\Repositories\MarkerRepository;

class MarkerController extends Controller
{
    /** @var type */
    protected $repository;
  
    /**
     * @param MarkerRepository $repository
     */
    public function __construct(MarkerRepository $repository)
    {
        $this->repository = $repository;
    }
    
     /**
     * Store resource to database
     * 
     * @param StoreMarkerRequest $request
     * @return Response
     */
    public function store(StoreMarkerRequest $request): Response {
        // Listing that will be associated to the marker
        $listing = Listing::where('id', $request->listing_id)->first();
            
        $marker = $this->repository->create($request, Auth::User(), $listing);

        return response($marker, 201);
    }

     /**
     * Updates a marker
     * 
     * @param int $id
     * @param UpdateMarkerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id, UpdateMarkerRequest $request): \Illuminate\Http\JsonResponse
    {        
        $marker = $this->repository->show($id);
        
        // validates and mutates $request->is_approved
        $user_approved = $request->userIsApproved(Auth::User(), $marker);
        
        if (!$user_approved) {
            return response()->json([], 401);
        }
        
        $marker = $this->repository->update($id, $request);

        return response()->json($marker);
    }
        
    /**
     * Destroys one marker
     * 
     * @param type $id
     * @param DestroyMarkerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Marker $marker, DestroyMarkerRequest $request): \Illuminate\Http\JsonResponse
    {
        $validation_error = $request->validateRequired($marker, Auth::User());
        
        if (! empty($validation_error)) {
            return response()->json($validation_error, 400);
        }
        
        $destroy = $this->repository->destroy($marker->id);
        
        return response()->json(['result' => 'deleted']);
    }
}
