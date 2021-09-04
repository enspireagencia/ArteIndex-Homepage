<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subheader')->nullable();
            $table->longText('body')->nullable();
            $table->string('image')->nullable();
            $table->longText('slug')->nullable();
            $table->date('post_date')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('my_posts');
    }
}
