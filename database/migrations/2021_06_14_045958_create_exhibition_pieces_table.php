<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitionPiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibition_pieces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('pieces_id')->nullable()->index();
            $table->foreignId('exhibition_id')->nullable()->index();
            $table->integer('status')->nullable();
            $table->string('award_name')->nullable();
            $table->boolean('is_award')->default(false);
            $table->foreignId('user_id')->nullable()->index();
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
        Schema::dropIfExists('exhibition_pieces');
    }
}
