<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'admin.set_report',
                    'display_name' => '设置报到状态',
                    'description' => '设置报到状态',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 2,
                    'name' => 'admin.select_dormitory',
                    'display_name' => '选择宿舍',
                    'description' => '选择宿舍',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 3,
                    'name' => 'admin.cancel_dormitory',
                    'display_name' => '取消选择宿舍',
                    'description' => '取消选择宿舍',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 4,
                    'name' => 'admin.show',
                    'display_name' => '查看学生信息',
                    'description' => '查看学生信息',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 5,
                    'name' => 'admin.search',
                    'display_name' => '搜索学生',
                    'description' => '搜索学生',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 6,
                    'name' => 'admin.cancel_report',
                    'display_name' => '取消报到',
                    'description' => '取消报到',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 7,
                    'name' => 'admin.get_available_dormitories',
                    'display_name' => '获取学生可选的宿舍',
                    'description' => '获取学生可选的宿舍',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 8,
                    'name' => 'admin.overview',
                    'display_name' => '获取总览数据',
                    'description' => '获取总览数据',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id' => 9,
                    'name' => 'admin.set_arrive_dorm',
                    'display_name' => '设置学生到达宿舍',
                    'description' => '设置学生到达宿舍',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            ]
        );
    }
}
