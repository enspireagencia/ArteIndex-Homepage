<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyDocument extends Model
{
    protected $table = 'my_documents';
    protected $fillable = [
        'name',
        'description',
        'date',
        'file_url',
        'type_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    public function document_type(){
        return $this->hasOne( 'App\Models\DocumentType' , 'id', 'type_id') ;
    }

    public function type(){
        return $this->hasMany( 'App\Models\DocumentType' , 'id', 'type_id') ;
    }
}
