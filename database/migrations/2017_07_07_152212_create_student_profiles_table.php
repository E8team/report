<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 学生详细信息表
 * Class CreateStudentProfilesTable
 */
class CreateStudentProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->unique()->comment('用户id');
            $table->string('graduate_school')->comment('毕业学校');
            $table->string('come_from')->comment('家乡');
            $table->char('tel', 11)->comment('手机');
            $table->float('height')->nullable()->comment('身高 单位：厘米');
            $table->float('weight')->nullable()->comment('体重 单位：斤');
            $table->text('remarks')->nullable()->comment('备注');
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
        Schema::dropIfExists('student_profiles');
    }
}
