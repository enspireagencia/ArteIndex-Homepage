<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('show_type')->nullable();
            $table->string('solo_group_show')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('fee')->nullable();
            $table->string('curator')->nullable();
            $table->string('juror')->nullable();
            $table->string('location_type')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('reception_date')->nullable();
            $table->date('submission_deadline')->nullable();
            $table->date('notification_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('pickup_date')->nullable();
            $table->longText('description')->nullable();
            $table->longText('notes')->nullable();
            $table->boolean('is_create_location_records_for_pieces_accepted_to_this_show')->default(false);
            $table->foreignId('location_id')->nullable()->index();
            $table->foreignId('duration_id')->nullable()->index();
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
        Schema::dropIfExists('exhibitions');
    }
}
