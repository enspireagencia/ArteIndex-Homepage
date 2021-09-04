<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = [
        'message',
        'remainder_date',
        'status',
        'user_id',
        'exhibition_id',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }

    public function exhibition_detail(){
        return $this->hasOne( 'App\Models\Exhibition' , 'id', 'exhibition_id') ;
    }
}
