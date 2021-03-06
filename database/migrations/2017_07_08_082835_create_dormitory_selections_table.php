<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 宿舍选择情况表
 * Class CreateDormitorySelectionsTable
 */
class CreateDormitorySelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitory_selections', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->primary();
            $table->unsignedInteger('dormitory_id')->index();
            $table->unsignedInteger('bed_num')->nullable()->comment('所选的床位号');
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
        Schema::dropIfExists('dormitory_selections');
    }
}
