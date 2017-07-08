<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentClassDormitoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_class_dormitory', function (Blueprint $table) {
            $table->unsignedInteger('department_class_id');
            $table->unsignedInteger('dormitory_id');
            $table->unsignedTinyInteger('galleryful')->comment('该宿舍在该班级的容纳人数');
            $table->primary(['department_class_id', 'dormitory_id'], 'class_id_dorm_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_class_dormitory');
    }
}
