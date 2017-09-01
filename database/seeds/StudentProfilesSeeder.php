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
                [
                    'student_id' => 10000,
                    'graduate_school' => 'abc中学',
                    'come_from' => '安徽省马鞍山市含山县',
                    'place_of_student' => '安徽省马鞍山市含山县',
                    'tel' => '13911111111'
                ],
                [
                    'student_id' => 10001,
                    'graduate_school' => 'abc中学',
                    'come_from' => '安徽省马鞍山市含山县',
                    'place_of_student' => '安徽省马鞍山市含山县',
                    'tel' => '13911111111'
                ]
            ]);
    }
}