<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditionWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edition_works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('inventory_number')->nullable();
            $table->string('price')->nullable();
            $table->string('wholesale_price')->nullable();
            $table->longText('notes')->nullable();
            $table->foreignId('location_id')->nullable()->index();
            $table->foreignId('edition_id')->nullable()->index();
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
        Schema::dropIfExists('edition_works');
    }
}
