<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';
    protected $fillable = [
        'name',
        'description',
        'plan_type_id',
        'created_at',
        'updated_at',
    ];
}
