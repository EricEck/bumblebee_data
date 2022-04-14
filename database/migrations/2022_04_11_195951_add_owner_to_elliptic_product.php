<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnerToEllipticProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elliptic_products', function (Blueprint $table) {
            $table->foreignId('pool_owner_id')->default(0);
            $table->foreignId('bow_component_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('elliptic_products', function (Blueprint $table) {
            $table->dropColumn('pool_owner_id');
            $table->dropColumn('bow_component_id');
        });
    }
}
