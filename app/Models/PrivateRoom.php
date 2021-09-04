<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateRoom extends Model
{
    protected $table = 'private_rooms';
    protected $fillable = [
        'name',
        'description',
        'show_public_piece_order',
        'show_public_show_prices',
        'show_public_show_sales',
        'show_public_show_status',
        'show_public_show_collections',
        'show_public_show_creation_date',
        'show_public_show_both_sizes',
        'show_public_show_additional_images',
        'show_public_show_inventory_numbers',
        'show_public_show_editions',
        'show_public_show_shadows',
        'show_public_show_other_work',
        'show_public_show_discovery_link',
        'show_public_pieces_per_page',
        'show_public_protected',
        'show_public_password',
        'show_public_show_inquire',
        'show_public_show_purchase',
        'show_public_show_location',
        'show_public_show_location_address',
        'show_public_show_wholesale_prices',
        'show_public_show_subject_matter',
        'show_public_show_piece_order',
        'notes',
        'piece_id',
        'user_id',
        'slug',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }

    public function private_rooom_pieces(){
        return $this->hasMany( 'App\Models\PrivateRoomPieces' , 'private_room_id', 'id') ;
    }
}
