<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duration', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hours')->nullable();
            $table->string('minutes')->nullable();
            $table->string('second')->nullable();
            $table->foreignId('pieces_id')->nullable()->index();
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
        Schema::dropIfExists('duration');
    }
}
