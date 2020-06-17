<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\User');
    }
    
    public function marker()
    {
        return $this->hasMany('App\Marker');
    }
}
