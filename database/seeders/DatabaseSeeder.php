<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CollegeDepartmentCourseSeeder::class,  // Must run BEFORE AdminSeeder (no dependency, just good order)
            AdminSeeder::class,
        ]);
    }
}
