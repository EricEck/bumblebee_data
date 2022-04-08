<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEllipticProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elliptic_products', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\EllipticModel::class)->default(0);
            $table->string('serial_number', 45)->default('');
            $table->foreignIdFor(\App\Models\Bumblebee::class)->default(0);
            $table->foreignIdFor(\App\Models\EllipticManufacturer::class)->default(0);
            $table->date('manufactured_on')->nullable()->default(null);
            $table->string('manufacture_construction_version',45)->default('');
            $table->string('manufacture_software_version',45)->default('');
            $table->date('warranty_stated_on')->nullable()->default(null);
            $table->date('warranty_ends_on')->nullable()->default(null);
            $table->string('current_construction_version',45)->default('');
            $table->string('current_software_version',45)->default('');
            $table->foreignId('installer_id')->default(0);
            $table->date('removed_from_service_on')->nullable()->default(null);

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
        Schema::dropIfExists('elliptic_products');
    }
}
