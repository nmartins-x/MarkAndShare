<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    public function listing()
    {
        return $this->belongsTo('App\Listing');
    }
}
