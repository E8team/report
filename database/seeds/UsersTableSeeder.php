<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'user_name' => 'e8',
                'name' => 'E8网络',
                'password' => bcrypt('e82017'),
                'department_id' => 1,
                //'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'id' => 2,
                'user_name' => 'jsj',
                'name' => '计算机学院',
                'password' => bcrypt('jsj2017'),
                'department_id' => 1,
                //'gender' => false,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}