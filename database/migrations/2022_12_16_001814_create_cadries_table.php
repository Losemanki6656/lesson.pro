<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('railway_id')->unsigned()->index()->nullable();
            $table->bigInteger('organization_id')->unsigned()->index()->nullable();
            $table->bigInteger('department_id')->unsigned()->index()->nullable();
            $table->bigInteger('position_id')->unsigned()->index()->nullable();
            $table->bigInteger('education_id')->unsigned()->index()->nullable();
            $table->string('fullname')->nullable();
            $table->string('photo')->nullable();
            $table->date('rail_date')->nullable();
            $table->date('job_date')->nullable();
            $table->date('position_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('status_position')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('status_work')->default(false);
            $table->foreign('railway_id')->references('id')->on('railways');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('education_id')->references('id')->on('educations');
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
        Schema::dropIfExists('cadries');
    }
}
