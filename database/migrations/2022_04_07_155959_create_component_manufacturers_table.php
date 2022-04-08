<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_manufacturers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 45)->default('')->nullable();
            $table->string('description', 256)->default('')->nullable();
            $table->string('website_main_url', 256)->default('')->nullable();
            $table->string('website_service_url', 256)->default('')->nullable();
            $table->boolean('is_elliptic_works')->default(0);

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
        Schema::dropIfExists('component_manufacturers');
    }
}

