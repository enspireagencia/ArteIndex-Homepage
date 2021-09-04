<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->longText('address_line_1')->nullable();
            $table->longText('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('report_header')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('instagram')->nullable();
            $table->longText('profile_footer')->nullable();
            $table->string('about_page_cover_photo')->nullable();
            $table->longText('short_bio')->nullable();
            $table->longText('biography')->nullable();
            $table->longText('statement')->nullable();
            $table->string('resume/cv')->nullable();
            $table->boolean('make_my_profile_public')->default(false);
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
        Schema::dropIfExists('my_profile');
    }
}
