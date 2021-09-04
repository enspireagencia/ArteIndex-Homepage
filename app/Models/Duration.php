<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    protected $table = 'duration';
    protected $fillable = [
        'hours',
        'minutes',
        'second',
        'pieces_id',
    ];
}
