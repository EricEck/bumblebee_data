<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoreUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            $table->string('phone_mobile',45)->default('');
            $table->string('phone_home',45)->default('');
            $table->string('phone_office',45)->default('');

            $table->foreignId('address_home_id');   // home address

            $table->foreignId('pool_owner_id');
            $table->foreignId('service_employee_id');
            $table->foreignId('elliptic_member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_mobile');
            $table->dropColumn('phone_home',);
            $table->dropColumn('phone_office');

            $table->dropColumn('address_home_id');

            $table->dropColumn('pool_owner_id');
            $table->dropColumn('service_employee_id');
            $table->dropColumn('elliptic_member_id');
        });
    }
}
