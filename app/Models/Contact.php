<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'default_image',
        'first_name',
        'last_name',
        'title',
        'phone',
        'work_phone',
        'mobile_phone',
        'email',
        'secondary_email',
        'website',
        'company_name',
        'job_title',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
        'country',
        'secondary_address1',
        'secondary_address2',
        'secondary_city',
        'secondary_state',
        'secondary_zip',
        'secondary_country',
        'group_id',
        'location_id',
        'bio',
        'notes',
        'creation_date',
        'dath_date',
        'nationality',
        'spouse_first_name',
        'spouse_last_name',
        'user_id',
        'slug'
    ];

    public function location(){
        return $this->hasOne('App\Models\Location', 'id',  'location_id');
    }
}
