<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Papersize extends Model
{
    protected $table = 'papersize';
    protected $fillable = [
        'height',
        'width',
        'pieces_id',
    ];
}
