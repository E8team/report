<?php

use Illuminate\Database\Seeder;

class StudentProfilesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student_profiles')->insert([
            'student_id'=>'1',
            'graduate_school'=>'含山县职教中心',
            'come_from'=>'安徽省马鞍山市含山县',
            'tel'=>'13956460801'
        ]);
    }
}