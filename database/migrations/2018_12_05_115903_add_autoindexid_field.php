<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoindexidField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sageitemsserials', function (Blueprint $table) {
            $table->string('autoindex_id')->nullable();
        });
    }

    /**autoindex_id
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sageitemsserials', function (Blueprint $table) {
            $table->dropColumn('autoindex_id');
        });
    }
}
