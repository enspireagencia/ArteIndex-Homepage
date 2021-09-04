<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitionPieces extends Model
{
  use HasFactory;
  protected $fillable = [
      'pieces_id',
      'exhibition_id',
      'status',
      'award_name',
      'is_award',
      'user_id',
  ];
  public function user(){
    return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
  }
  public function exhibition(){
    return $this->hasOne( 'App\Models\Exhibition' , 'id', 'exhibition_id') ;
  }
  public function pieces(){
    return $this->hasOne( 'App\Models\Pieces' , 'id', 'pieces_id') ;
  }
}
