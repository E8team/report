<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            [
                'id' => 10000,
                'student_num' => '1508220227',
                'student_name' => '陶煜',
                'abbreviation_pinyin1' => 'ty',
                'abbreviation_pinyin2' => '',
                'full_pinyin1' => 'taoyu',
                'full_pinyin2' => '',
                'id_card' => '342625199711111111',
                'department_class_id' => 4,
                'department_id' => 1,
                'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'id' => 10001,
                'student_num' => '1508220228',
                'student_name' => '陶炜',
                'abbreviation_pinyin1' => 'tw',
                'abbreviation_pinyin2' => '',
                'full_pinyin1' => 'taowei',
                'full_pinyin2' => '',
                'id_card' => '342625199721111111',
                'department_class_id' => 4,
                'department_id' => 1,
                'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}