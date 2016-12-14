<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('last_name');
            $table->text('first_name');
            $table->text('company_name');
            $table->text('phone_nr');
            $table->text('fax_nr');
            $table->text('email');
            $table->text('profession');
            $table->text('address');
            $table->text('postal_code');
            $table->text('interest');
            $table->text('type');
            $table->text('type2');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
