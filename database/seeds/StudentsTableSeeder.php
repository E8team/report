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
            'student_num'=>'1508220227',
            'student_name'=>'陶煜',
            'abbreviation_pinyin1'=>'ty',
            'abbreviation_pinyin2'=>'',
            'full_pinyin1'=>'taoyu',
            'full_pinyin2'=>'',
            'id_card_num'=>'342625199703130313',
            'graduate_school'=>'含山县职教中心',
            'come_from'=>'安徽省马鞍山市含山县',
            'tel'=>'13956460801',
            'department_class_id'=>4
        ]);
    }
}