<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dimension extends Model
{
    protected $table = 'dimension';
    protected $fillable = [
        'length',
        'width',
        'depth',
        'pieces_id',
    ];
}
