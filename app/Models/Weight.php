<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $table = 'weight';
    protected $fillable = [
        'weight',
        'pieces_id',
    ];
}
