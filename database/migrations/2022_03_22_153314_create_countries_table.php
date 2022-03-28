<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->default('');
            $table->string('short_name', 64)->default('');
            $table->string('country_code', 3)->default(''); //added for use in forward geocoding per ISO 3166-1 Alpha 2: https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
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
        Schema::dropIfExists('countries');
    }
}
