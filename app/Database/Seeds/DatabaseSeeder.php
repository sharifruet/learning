<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        // Uncomment the line below to use master data instead of CourseSeeder
        // $this->call('CourseSeeder');
        $this->call('MasterDataSeeder');
    }
}

