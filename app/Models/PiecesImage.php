<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiecesImage extends Model
{
    protected $table = 'pieces_images';
    protected $fillable = [
        'url',
        'piece_id',
    ];
}
