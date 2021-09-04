<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieces extends Model
{
    protected $table = 'pieces';
    protected $fillable = [
        'title',
        'creation_date',
        'price',
        'wholesale_price',
        'inventory_number',
        'description',
        'notes',
        'signatures',
        'linkToPurchasePiece',
        'artType_id',
        'status_id',
        'dimension_id',
        'weight_id',
        'paper_id',
        'frame_id',
        'location_id',
        'collections_id',
        'artist_id',
        'user_id',
        'tag_list',
        'medium',
        'subject_matter',
        'slug',
        'piece_creation_date_is_circa',
        'piece_framed',
        'piece_signed',
        'piece_public',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->hasOne( 'App\Models\User' , 'id', 'user_id') ;
    }

    public function pieces_images(){
        return $this->hasMany( 'App\Models\PiecesImage' , 'piece_id', 'id') ;
    }

    public function duration(){
        return $this->hasOne( 'App\Models\Duration' , 'pieces_id', 'id') ;
    }

    public function dimension(){
        return $this->hasOne( 'App\Models\Dimension' , 'pieces_id', 'id') ;
    }

    public function art_type(){
        return $this->hasOne( 'App\Models\ArtType' , 'id', 'artType_id') ;
    }

    public function paper_size(){
        return $this->hasOne( 'App\Models\Papersize' , 'pieces_id', 'id') ;
    }

    public function weight(){
        return $this->hasOne( 'App\Models\Weight' , 'pieces_id', 'id') ;
    }

    public function status(){
        return $this->hasOne( 'App\Models\Status' , 'id', 'status_id') ;
    }

    public function location(){
        return $this->hasOne( 'App\Models\Location' , 'id', 'location_id') ;
    }
}
