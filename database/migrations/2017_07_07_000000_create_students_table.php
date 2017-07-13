<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 新生表
 * Class CreateStudentsTable
 */
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
            $table->char('wx_openid', 28)->unique()->nullable()->comment('微信openid');
            $table->unsignedInteger('department_class_id')->index()->comment('班级id');
            $table->unsignedInteger('department_id')->index()->comment('学院id');
            $table->boolean('gender')->comment('性别 false-男 true-女');
            $table->char('id_card', 18)->unique()->comment('身份证号码');
            $table->timestamp('report_at')->nullable()->comment('报到时间 此字段为null表示不未报到');
            $table->timestamp('arrive_dorm_at')->nullable()->comment('到达宿舍时间 此字段为null表示不未到达宿舍');
            $table->timestamp('allow_report_at')->nullable()->comment('允许报到时间 此字段为null表示不允许报到');
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
}
