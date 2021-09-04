<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->date('creation_date')->nullable();
            $table->string('medium')->nullable();
            $table->string('cost')->nullable();
            $table->string('prints_count')->nullable();
            $table->string('sales_price')->nullable();
            $table->string('proofs_count')->nullable();
            $table->string('size_height')->nullable();
            $table->string('size_width')->nullable();
            $table->string('size_depth')->nullable();
            $table->longText('notes')->nullable();
            $table->boolean('signed')->default(false);
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
        Schema::dropIfExists('runs');
    }
}
