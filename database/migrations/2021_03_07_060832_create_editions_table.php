<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('default_image')->nullable();
            $table->longText('description')->nullable();
            $table->longText('notes')->nullable();
            $table->string('initial_pieces')->nullable();
            $table->string('initial_proofs')->nullable();
            $table->string('limitied_edition_number')->nullable();
            $table->boolean('open_edition')->default(false);
            $table->boolean('limited_seats')->default(false);
            $table->foreignId('piece_id')->nullable()->index();
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
        Schema::dropIfExists('editions');
    }
}
