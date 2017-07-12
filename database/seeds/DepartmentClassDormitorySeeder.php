<?php

use Illuminate\Database\Seeder;

class DepartmentClassDormitorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('department_class_dormitory')->insert([
            [
                'department_class_id' => 4,
                'dormitory_id' => 1,
                'galleryful' => 6
            ], [
                'department_class_id' => 4,
                'dormitory_id' => 2,
                'galleryful' => 6
            ], [
                'department_class_id' => 4,
                'dormitory_id' => 3,
                'galleryful' => 2
            ], [
                'department_class_id' => 4,
                'dormitory_id' => 4,
                'galleryful' => 3
            ]
        ]);
    }
}