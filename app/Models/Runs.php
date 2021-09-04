<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Runs extends Model
{
    protected $table = 'runs';
    protected $fillable = [
        'name',
        'creation_date',
        'medium',
        'cost',
        'prints_count',
        'sales_price',
        'proofs_count',
        'size_height',
        'size_width',
        'size_depth',
        'notes',
        'signed',
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
