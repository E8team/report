<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('student_num', 10)->unique()->comment('学号');
            $table->string('student_name')->comment('学生姓名');
            $table->string('abbreviation_pinyin1')->comment('学生姓名拼音首字母');
            $table->string('abbreviation_pinyin2')->comment('学生姓名拼音首字母');
            $table->string('full_pinyin1')->comment('学生姓名完整拼音');
            $table->string('full_pinyin2')->comment('学生姓名完整拼音');
            $table->char('wx_openid', 28)->unique()->comment('微信openid');
            $table->unsignedBigInteger('class_id')->index()->comment('班级id');
            $table->boolean('gender')->comment('性别 false-男 true-女');
            $table->char('id_card', 18)->unique()->comment('身份证号码');
            $table->timestamp('report_time')->nullable()->comment('报到时间');
            $table->timestamp('arrive_dorm_time')->nullable()->comment('到达宿舍时间');
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
        Schema::dropIfExists('users');
    }
}
