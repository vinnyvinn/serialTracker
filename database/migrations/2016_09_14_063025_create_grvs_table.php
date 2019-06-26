<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sagegrv_id');
            $table->bigInteger('autoindex_id');
            $table->bigInteger('InvNumber');
            $table->string('GrvNumber');
            $table->string('Description');
            $table->date('DeliveryDate');
            $table->string('OrderNum');
            $table->string('cAccountName');
            $table->string('status');
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
        Schema::drop('grvs');
    }
}
