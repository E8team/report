<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 班级表
        Schema::create('department_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('short_title');
            $table->unsignedInteger('parent_id')->index();
            $table->unsignedInteger('sort')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_classes');
    }
}
