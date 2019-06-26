<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDnotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dnotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dnote_num');
            $table->bigInteger('invoice_id');
            $table->string('invoice_num');
            $table->string('client_name');
            $table->date('invoice_date');
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
        Schema::drop('dnotes');
    }
}
