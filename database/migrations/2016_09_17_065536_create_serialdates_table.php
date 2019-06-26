<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerialdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serialdates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user');
            $table->integer('sageitemsserial_id');
            $table->date('labour_start_date');
            $table->date('service_start_date');
            $table->date('parts_start_date');
            $table->date('labour_end_date');
            $table->date('service_end_date');
            $table->date('parts_end_date');
            $table->timestamps();

//            $table->foreign('sageitemsserial_id')
//            ->references('id')->on('sageitemsserials')
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
        Schema::drop('serialdates');
    }
}
