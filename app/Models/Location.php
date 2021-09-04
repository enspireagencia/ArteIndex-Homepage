<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';
    protected $fillable = [
        'name',
        'website',
        'email',
        'phone',
        'fax',
        'notes',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zipcode',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }

    public function contact(){
        return $this->hasMany('App\Models\Contact', 'country', 'id');
    }
    
    public function country_list(){
        return $this->hasOne('App\Models\Country', 'id', 'country');
    }
}
