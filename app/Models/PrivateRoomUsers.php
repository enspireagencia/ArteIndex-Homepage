<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateRoomUsers extends Model
{
    protected $table = 'private_rooms_users';
    protected $fillable = [
        'user_id',
        'piece_id',
        'created_at',
        'updated_at',
    ];
}
