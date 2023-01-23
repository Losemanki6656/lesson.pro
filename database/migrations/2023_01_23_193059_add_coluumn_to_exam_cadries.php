<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColuumnToExamCadries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_cadries', function (Blueprint $table) {
            $table->boolean('status_dont_exam')->default(false);
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
            $table->dropColumn("status_dont_exam");
        });
    }
}
