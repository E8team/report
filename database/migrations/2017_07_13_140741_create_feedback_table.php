<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 反馈表
 */
class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('feedback_type')->comment('反馈类型');
            $table->string('contact')->nullable()->comment('联系方式');
            $table->longText('content')->commnet('反馈详情');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
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
        Schema::dropIfExists('feedback');
    }
}
