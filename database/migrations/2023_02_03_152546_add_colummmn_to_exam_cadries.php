<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColummmnToExamCadries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_cadries', function (Blueprint $table) {
            $table->bigInteger('department_id')->unsigned()->index()->nullable();
            $table->bigInteger('position_id')->unsigned()->index()->nullable();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_cadries', function (Blueprint $table) {
            $table->dropColumn("department_id");
            $table->dropColumn("position_id");
            $table->dropColumn("user_id");
        });
    }
}
