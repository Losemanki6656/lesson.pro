<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColuumnToCadries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadries', function (Blueprint $table) {
            $table->bigInteger('management_id')->unsigned()->index()->nullable();
            $table->foreign('management_id')->references('id')->on('management');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadries', function (Blueprint $table) {
            $table->dropColumn("management_id");
        });
    }
}
