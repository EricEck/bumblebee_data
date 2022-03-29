<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_companies', function (Blueprint $table) {
            $table->id();

            $table->string('name', 128)->default('');

            $table->foreignId('address_primary_id');
            $table->boolean('billing_same_as_address')->default(true);
            $table->foreignId('address_billing_id');

            $table->foreignId('contact_primary_id');
            $table->foreignId('contact_billing_id');
            $table->foreignId('contact_technical_id');
            $table->foreignId('contact_service_id');

            $table->string('phone_office',45)->default('');
            $table->string('phone_fax',45)->default('');
            $table->string('email_primary',128)->default('');

            $table->string('website_url',256)->default('');

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
        Schema::dropIfExists('service_companies');
    }
}
