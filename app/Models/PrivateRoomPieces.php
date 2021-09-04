<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateRoomPieces extends Model
{
    protected $table = 'private_rooms_piece';
    protected $fillable = [
        'private_room_id',
        'piece_id',
        'created_at',
        'updated_at',
    ];

    public function pieces_detail(){
        return $this->hasOne( 'App\Models\Pieces' , 'id', 'piece_id') ;
    }
}
