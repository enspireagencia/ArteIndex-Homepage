<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{
    protected $table = 'editions';
    protected $fillable = [
        'name',
        'default_image',
        'description',
        'notes',
        'initial_pieces',
        'initial_proofs',
        'limitied_edition_number',
        'open_edition',
        'limited_seats',
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

    public function pieces_images(){
        return $this->hasMany( 'App\Models\PiecesImage' , 'piece_id', 'piece_id') ;
    }

}
