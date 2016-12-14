<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('product_name');
            $table->text('product_type');
            $table->text('product_type2');
            $table->text('technika');
            $table->text('meret');
            $table->text('egyeb');
            $table->text('beszerzes_status');
            $table->text('allapot');
            $table->text('kor');
            $table->text('muvesz');
            $table->integer('beszerzesi_ar');
            $table->integer('bizomanyosi_ar');
            $table->integer('ajanlott_ar');
            $table->integer('eladasi_ar');
            $table->integer('eloleg');
            $table->text('kifizetes_tipus');
            $table->text('eladas_status');
            $table->date('bevitel_date');
            $table->date('lejarat_date');
            $table->date('elvitel_date');
            $table->date('berles_start_date');
            $table->date('berles_end_date');
            $table->text('ertekesito');
            $table->text('uzlethelyiseg');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('invoice_id');
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
        Schema::dropIfExists('products');
    }
}
