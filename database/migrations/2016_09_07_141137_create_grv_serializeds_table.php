<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrvSerializedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grv_serializeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('autoindex_id');
            $table->bigInteger('grvlines_id');
            $table->string('description');
            $table->bigInteger('qty_serialized');
            $table->string('code');
            $table->bigInteger('fQuantity');
            $table->bigInteger('qty_remaining');
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
        Schema::drop('grv_serializeds');
    }
}
