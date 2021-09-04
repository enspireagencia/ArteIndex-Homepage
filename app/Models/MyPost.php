<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subheader',
        'body',
        'image',
        'slug',
        'post_date',
        'status',
        'user_id',
    ];
}
