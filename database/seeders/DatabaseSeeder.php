<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(SessionSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
    }
}
