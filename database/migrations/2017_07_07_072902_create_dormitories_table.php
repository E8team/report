<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 宿舍表
 * Class CreateDormitoriesTable
 */
class CreateDormitoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dormitories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('galleryful')->comment('容纳人数');
            $table->char('dorm_num', 6)->comment('宿舍号');
            $table->unsignedTinyInteger('insert_dormitory_num')->default(0)->comment('不是插宿该字段值为0 否则值为该宿舍可容纳的人数');
            $table->boolean('is_together_dormitory')->comment('是否为合宿');
            $table->boolean('gender')->comment('性别 false-男 true-女');
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
        Schema::dropIfExists('dormitories');
    }
}
