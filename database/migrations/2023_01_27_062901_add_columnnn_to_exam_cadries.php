<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnnnToExamCadries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_cadries', function (Blueprint $table) {
            $table->integer('year_exam')->nullable();
            $table->integer('year_quarter')->nullable();
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
            $table->dropColumn("year_exam");
            $table->dropColumn("year_quarter");
        });
    }
}
