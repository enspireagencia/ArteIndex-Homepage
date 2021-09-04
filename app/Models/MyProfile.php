<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyProfile extends Model
{
    protected $table = 'my_profile';
    protected $fillable = [
        'name',
        'phone',
        'website',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'profile_image',
        'logo',
        'report_header',
        'facebook',
        'twitter',
        'linkedIn',
        'pinterest',
        'instagram',
        'profile_footer',
        'about_page_cover_photo',
        'short_bio',
        'biography',
        'statement',
        'resume/cv',
        'make_my_profile_public',
        'user_id',
        'created_at',
        'updated_at',
    ];
}
