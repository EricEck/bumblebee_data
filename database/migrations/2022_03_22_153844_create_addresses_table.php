<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street_1', 128)->default('');
            $table->string('street_2', 128)->default('');
            $table->string('street_3', 128)->default('');

            $table->string('city_name', 128)->default('');
            $table->string('postal_code', 128)->default('');

            $table->foreignId('state_id');
            $table->foreignId('country_id');

            $table->decimal('latitude', 10,8)->default(null);
            $table->decimal('longitude', 11,8)->default(null);

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
        Schema::dropIfExists('addresses');
    }
}
