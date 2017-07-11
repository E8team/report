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
                    'id'=>1,
                    'name' => 'admin.set_report',
                    'display_name' => '设置报到状态',
                    'description' => '设置报到状态',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id'=>2,
                    'name' => 'admin.select_dormitory',
                    'display_name' => '选择宿舍',
                    'description' => '选择宿舍',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id'=>3,
                    'name' => 'admin.cancel_dormitory',
                    'display_name' => '取消选择宿舍',
                    'description' => '取消选择宿舍',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'id'=>4,
                    'name' => 'admin.show',
                    'display_name' => '查看报到状态',
                    'description' => '查看报到状态',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
            ]
        );
    }
}
