<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_workers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('teacher_id')->unsigned()->index()->nullable();
            $table->bigInteger('worker_id')->unsigned()->index()->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->date('exam_date')->nullable();
            $table->integer('ball')->nullable();
            $table->string('price')->nullable();
            $table->boolean('status_exam')->default(false);
            $table->boolean('status')->default(false);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('teacher_id')->references('id')->on('cadries');
            $table->foreign('worker_id')->references('id')->on('cadries');
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
        Schema::dropIfExists('teacher_workers');
    }
}
