<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
            [
                'id' => 1,
                'name' => 'super_admin',
                'display_name' => '超管',
                'description' => '超级管理员',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'jsj_admin',
                'display_name' => '计算机学院管理员',
                'description' => '计算机学院管理员',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
            ]
        );
    }
}
