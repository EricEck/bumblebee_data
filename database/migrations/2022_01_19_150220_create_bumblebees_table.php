<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBumblebeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bumblebees', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number',128)->unique();
            $table->date('manufactured_date')->nullable();
            $table->string('current_version',128)->nullable();  // current hardware version
            $table->foreignId('manufacturer_id')->nullable();   // who manufactured it originally
            $table->foreignId('owner_id')->nullable();  // who is the owner
            $table->foreignId('install_id')->nullable(); // where in a pool is it installed
            $table->date('assigned_to_owner_on')->nullable();
            $table->boolean('removed_from_service')->default(0);
            $table->string('api_password')->nullable();
            $table->uuid('remember_token');
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
        Schema::dropIfExists('bumblebees');
    }
}
