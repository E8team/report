<?php

use Illuminate\Database\Seeder;

class DepartmentClasses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_classes')->insert([
            [
                'id' => 1,
                'title' => '计算机学院',
                'short_title' => null,
                'parent_id' => 0,
                'order' => 0
            ],
            [
                'id' => 2,
                'title' => '2017',
                'short_title' => '17',
                'parent_id' => 1,
                'order' => 0
            ],
            [
                'id' => 3,
                'title' => '网络工程',
                'short_title' => '网工',
                'parent_id' => 2,
                'order' => 0
            ],
            [
                'id' => 4,
                'title' => '3',
                'short_title' => null,
                'parent_id' => 3,
                'order' => 0
            ],
        ]);
    }
}