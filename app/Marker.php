<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $fillable = [
        'user_id', 'listing_id', 'name', 'description', 'lgt', 'lat', 'is_approved'
    ];
    
    public function listing()
    {
        return $this->belongsTo('App\Listing');
    }
}
