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
            'id'=>10000,
            'student_num'=>'1508220227',
            'student_name'=>'陶煜',
            'abbreviation_pinyin1'=>'ty',
            'abbreviation_pinyin2'=>'',
            'full_pinyin1'=>'taoyu',
            'full_pinyin2'=>'',
            'id_card'=>'342625199703130313',
            'department_class_id'=>4,
            'gender'=>false,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}