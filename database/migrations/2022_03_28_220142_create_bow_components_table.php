<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBowComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bow_components', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\BodiesOfWater::class);

            $table->string('name', 128)->default('');
            $table->string('description', 512)->default('');

            $table->foreignId('elliptic_product_id');
            $table->foreignId('manufacturer_id');

            $table->foreignId('installation_service_company_id');
            $table->foreignId('installation_service_ticket_id');
            $table->date('installation_date')->default(null);
            $table->foreignId('installation_location_id');
            $table->boolean('installed_now')->default(false);

            $table->boolean('warranty')->default(false);
            $table->date('warranty_end_date')->default(null);

            $table->string('model_number', 128)->default('');
            $table->string('serial_number', 128)->default('');

            $table->date('removed_from_service_date')->default(null);
            $table->foreignId('removed_from_service_ticket_id');

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
        Schema::dropIfExists('bow_components');
    }
}
