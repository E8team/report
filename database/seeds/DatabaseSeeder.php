<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(UserProfilesSeeder::class);
        $this->call(DepartmentClasses::class);
        $this->call(DormitoriesSeeder::class);
        $this->call(DepartmentClassDormitorySeeder::class);
    }
}
