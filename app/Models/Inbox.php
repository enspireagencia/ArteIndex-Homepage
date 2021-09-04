<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;
    protected $fillable = [
        'pieces_id',
        'name',
        'email',
        'phone',
        'message',
        'private_room_id',
        'type',
        'archive_id',
        'user_id',
   ];
   public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }

   public function pieces_detail(){
    return $this->hasOne( 'App\Models\Pieces' , 'id', 'pieces_id') ;
  }

  public function private_room(){
    return $this->hasOne( 'App\Models\PrivateRoom' , 'id', 'private_room_id') ;
  }

}
