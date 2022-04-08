<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEllipticModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elliptic_models', function (Blueprint $table) {
            $table->id();

            $table->string('name', 45)->default('')->nullable();
            $table->string('description', 512)->default('')->nullable();
            $table->boolean('is_bumblebee')->default(0);
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('elliptic_models');
    }
}
