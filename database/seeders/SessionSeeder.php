<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sessions = [
            ['id' => 1,'title' => '2021-2022'],
            ['id' => 2,'title' => '2022-2023'],
            ['id' => 3,'title' => '2023-2024'],
            ['id' => 4,'title' => '2024-2025'],
            ['id' => 5,'title' => '2025-2026'],
        ];
        foreach ($sessions as $value) {
            Session::create($value);
        }
    }
}
