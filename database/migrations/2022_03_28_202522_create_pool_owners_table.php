<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_owners', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor('user_id');

            $table->boolean('billing_same_as_address')->default(true);
            $table->foreignId('billing_address_id');

            $table->boolean('is_primary_owner')->default(false);
            $table->foreignId('primary_owner_id');

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
        Schema::dropIfExists('pool_owners');
    }
}
