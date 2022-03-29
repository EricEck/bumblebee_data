<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCompanyLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_company_locations', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\ServiceCompany::class);
            $table->foreignIdFor(\App\Models\Address::class);

            $table->boolean('active')->default(false);
            $table->string('name', 128)->default('');
            $table->string('description', 512)->default('');

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
        Schema::dropIfExists('service_company_locations');
    }
}
