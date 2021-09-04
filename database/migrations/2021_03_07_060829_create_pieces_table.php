<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->date('creation_date')->nullable();
            $table->string('price')->nullable();
            $table->string('wholesale_price')->nullable();
            $table->string('inventory_number')->nullable();
            $table->longText('description')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('signatures')->nullable();
            $table->string('linkToPurchasePiece')->nullable();
            $table->integer('artType_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('dimension_id')->nullable();
            $table->integer('weight_id')->nullable();
            $table->integer('paper_id')->nullable();
            $table->integer('frame_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('collections_id')->nullable();
            $table->integer('artist_id')->nullable();
            $table->foreignId('user_id')->nullable()->index();
            $table->longText('tag_list')->nullable();
            $table->string('medium')->nullable();
            $table->string('subject_matter')->nullable();
            $table->longText('slug')->nullable();
            $table->boolean('piece_creation_date_is_circa')->default(false);
            $table->boolean('piece_framed')->default(false);
            $table->boolean('piece_signed')->default(false);
            $table->boolean('piece_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pieces');
    }
}
