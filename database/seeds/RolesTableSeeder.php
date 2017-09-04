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
                    'name' => 'student_union',
                    'display_name' => '学生会',
                    'description' => '学生会',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 3,
                    'name' => 'dz',
                    'display_name' => '党站',
                    'description' => '党站',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            ]
        );
    }
}
