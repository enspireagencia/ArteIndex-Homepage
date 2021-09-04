<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('show_public_piece_order')->nullable();
            $table->boolean('show_public_show_prices')->default(false);
            $table->boolean('show_public_show_sales')->default(false);
            $table->boolean('show_public_show_status')->default(false);
            $table->boolean('show_public_show_collections')->default(false);
            $table->boolean('show_public_show_creation_date')->default(false);
            $table->boolean('show_public_show_both_sizes')->default(false);
            $table->boolean('show_public_show_additional_images')->default(false);
            $table->boolean('show_public_show_inventory_numbers')->default(false);
            $table->boolean('show_public_show_editions')->default(false);
            $table->boolean('show_public_show_shadows')->default(false);
            $table->boolean('show_public_show_other_work')->default(false);
            $table->boolean('show_public_show_discovery_link')->default(false);
            $table->string('show_public_pieces_per_page')->default(false);
            $table->boolean('show_public_protected')->default(false);
            $table->string('show_public_password')->nullable();
            $table->boolean('show_public_show_inquire')->default(false);
            $table->boolean('show_public_show_purchase')->default(false);
            $table->boolean('show_public_show_location')->default(false);
            $table->boolean('show_public_show_location_address')->default(false);
            $table->boolean('show_public_show_wholesale_prices')->default(false);
            $table->boolean('show_public_show_subject_matter')->default(false);
            $table->boolean('show_public_show_piece_order')->default(false);
            $table->longText('notes')->nullable();
            $table->foreignId('piece_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('private_rooms');
    }
}
