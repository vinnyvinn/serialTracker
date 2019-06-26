<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSageitemsserialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sageitemsserials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grv_id')->unsigned();
            $table->text('warrant');
            $table->bigInteger('idInvoiceLines');
            $table->bigInteger('inv_idInvoiceLines');
            $table->string('cDescription');
            $table->double('fUnitcost');
            $table->string('code');
            $table->string('user');
            $table->double('fUnitPriceExcl');
            $table->string('serial_one')->nullable();
            $table->string('serial_two')->nullable();
            $table->string('serial_three')->nullable();
            $table->string('serial_four')->nullable();
            $table->string('status');
            $table->timestamps();

//           $table->foreign('grv_id')
//            ->references('id')->on('grvs')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sageitemsserials');
    }
}
