<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';
    protected $fillable = [
        'collection_name',
        'description',
        'user_id',
        'hide_from_public',
    ];

    public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }
    public function pieces(){
        return $this->hasMany( 'App\Models\Pieces' , 'id', 'pieces_id') ;
    }
}
