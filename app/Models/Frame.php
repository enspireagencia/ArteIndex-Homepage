<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    protected $table = 'frame';
    protected $fillable = [
        'height',
        'width',
        'depth',
        'pieces_id',
    ];
}
