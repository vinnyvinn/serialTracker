<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issuelines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('grv_id');
            $table->bigInteger('autoindex_id');
            $table->bigInteger('idInvoiceLines');
            $table->string('cDescription');
            $table->double('fUnitcost');
            $table->string('code');
            $table->double('fUnitPriceExcl');
            $table->string('issued_amount');
            $table->string('previous_amount');
            $table->string('remaining_amount');
            $table->string('status');
            $table->string('serial');
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
        Schema::drop('issuelines');
    }
}
