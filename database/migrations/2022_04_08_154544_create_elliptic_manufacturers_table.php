<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEllipticManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elliptic_manufacturers', function (Blueprint $table) {
            $table->id();

            $table->string('name',128)->default('');
            $table->string('description',512)->default('');
            $table->foreignIdFor(\App\Models\Address::class)->default(0);
            $table->string('contact',128)->default('');
            $table->string('phone_work',128)->default('');
            $table->string('email_work',128)->default('');
            $table->string('website_main_url',128)->default('');

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
        Schema::dropIfExists('elliptic_manufacturers');
    }
}
