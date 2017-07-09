<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentClassInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_class_infos', function (Blueprint $table) {
            $table->unsignedTinyInteger('department_class_id')->primary();
            $table->boolean('boy_normal_dorm_finished')->comment('男生普通宿舍是否已经选完');
            $table->boolean('girl_normal_dorm_finished')->comment('女生普通宿舍是否已经选完');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_class_infos');
    }
}
