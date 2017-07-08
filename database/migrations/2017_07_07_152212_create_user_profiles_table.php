<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->unique()->comment('用户id');
            $table->string('graduate_school')->comment('毕业学校');
            $table->string('come_from')->comment('家乡');
            $table->char('tel', 11)->comment('手机');
            $table->float('height')->comment('身高 单位：厘米');
            $table->float('weight')->comment('体重 单位：斤');
            $table->text('remarks')->comment('备注');
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
        Schema::dropIfExists('user_profiles');
    }
}
