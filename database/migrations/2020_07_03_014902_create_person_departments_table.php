<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned()->index();
            $table->integer('person_id')->unsigned()->index();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('person_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person_departments');
    }
}
