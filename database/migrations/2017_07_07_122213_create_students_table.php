<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->char('student_num', 10)->unique()->comment('学号');
            $table->string('student_name')->comment('学生姓名');
            $table->string('abbreviation_pinyin1')->comment('学生姓名拼音首字母');
            $table->string('abbreviation_pinyin2')->comment('学生姓名拼音首字母');
            $table->string('full_pinyin1')->comment('学生姓名完整拼音');
            $table->string('full_pinyin2')->comment('学生姓名完整拼音');
            $table->char('id_card_num', 18)->unqiue()->comment('身份证号码');
            $table->string('graduate_school')->comment('毕业学校');
            $table->string('come_from')->comment('家乡');
            $table->char('tel', 11)->comment('手机');
            $table->unsignedInteger('department_class_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
