<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditionWorks extends Model
{
    protected $table = 'edition_works';
    protected $fillable = [
        'inventory_number',
        'price',
        'wholesale_price',
        'notes',
        'location_id',
        'edition_id',
        'piece_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }

    public function pieces_detail(){
        return $this->hasOne( 'App\Models\Pieces' , 'id', 'piece_id') ;
    }

    public function location_detail(){
        return $this->hasOne( 'App\Models\Location' , 'id', 'location_id') ;
    }

    public function edition_detail(){
        return $this->hasOne( 'App\Models\Edition' , 'id', 'edition_id') ;
    }
}
