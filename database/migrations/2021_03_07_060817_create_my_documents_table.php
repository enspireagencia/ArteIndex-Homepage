<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('my_documents')) {
            Schema::create('my_documents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->longText('description')->nullable();
                $table->date('date')->nullable();
                $table->longText('file_url')->nullable();
                $table->foreignId('type_id')->nullable()->index();
                $table->foreignId('user_id')->nullable()->index();
                $table->timestamps();
            });
        }   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_documents');
    }
}
