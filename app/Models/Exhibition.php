<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'show_type',
        'solo_group_show',
        'phone',
        'email',
        'website',
        'fee',
        'curator',
        'juror',
        'location_type',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'zip',
        'country',
        'start_date',
        'end_date',
        'reception_date',
        'submission_deadline',
        'notification_date',
        'delivery_date',
        'pickup_date',
        'description',
        'notes',
        'is_create_location_records_for_pieces_accepted_to_this_show',
        'location_id',
        'duration_id',
        'user_id',
   ];
   public function user(){
      return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
  }

    public function location(){
      return $this->hasOne( 'App\Models\Location' , 'id', 'location_id') ;
    }

  public function duration(){
    return $this->hasOne( 'App\Models\Duration' , 'id', 'duration_id') ;
  }

  public function country_name(){
    return $this->hasOne( 'App\Models\Country' , 'id', 'country') ;
  }

}
