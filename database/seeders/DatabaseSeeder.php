<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(SessionSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(AppSettingSeeder::class);
    }
}
