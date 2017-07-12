<?php

use Illuminate\Database\Seeder;

class DormitoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dormitories')->insert([
            [
                'id' => 1,
                'galleryful' => 6,
                'dorm_num' => '09A103',
                'insert_dormitory_num' => 0,
                'is_together_dormitory' => false,
                'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 2,
                'galleryful' => 6,
                'dorm_num' => '09A104',
                'insert_dormitory_num' => 0,
                'is_together_dormitory' => false,
                'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 3,
                'galleryful' => 4,
                'dorm_num' => '09A105',
                'insert_dormitory_num' => 2,
                'is_together_dormitory' => false,
                'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 4,
                'galleryful' => 4,
                'dorm_num' => '09A106',
                'insert_dormitory_num' => 0,
                'is_together_dormitory' => true,
                'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}