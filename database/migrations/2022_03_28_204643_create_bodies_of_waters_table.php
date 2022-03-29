<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodiesOfWatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodies_of_waters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pool_owner_id');
            $table->string('name', 45)->default('');
            $table->string('description_pool', 1024)->default('');

            $table->foreignIdFor(\App\Models\Address::class);
            $table->foreignId('location_type_id');
            $table->string('description_access', 512)->default('');


            $table->decimal('latitude', 10,8)->default(null);
            $table->decimal('longitude', 11,8)->default(null);

            $table->foreignId('filtration_type_id');
            $table->foreignId('filteration_share_with_bow_id');

            $table->foreignId('construction_type_id');
            $table->string('description_construction', 1024)->default('');
            $table->date('construction_date')->default(null);
            $table->boolean('commercial');
            $table->boolean('indoor')->default(false);

            $table->integer('gallons');

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
        Schema::dropIfExists('bodies_of_waters');
    }
}
