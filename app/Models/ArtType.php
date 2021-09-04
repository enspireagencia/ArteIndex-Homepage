<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtType extends Model
{
    protected $table = 'art_type';
    protected $fillable = [
        'name',
    ];
}
