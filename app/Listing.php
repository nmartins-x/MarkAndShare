<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'unique_url', 'public_listed'
    ];
        
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function markers()
    {
        return $this->hasMany('App\Marker');
    }
}
