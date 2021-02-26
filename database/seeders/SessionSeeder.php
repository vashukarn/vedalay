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
            ['id' => 1,'start_year' => '2021','end_year' => '2022', 'created_by' => 1],
            ['id' => 2,'start_year' => '2022','end_year' => '2023', 'created_by' => 1],
            ['id' => 3,'start_year' => '2023','end_year' => '2024', 'created_by' => 1],
            ['id' => 4,'start_year' => '2024','end_year' => '2025', 'created_by' => 1],
            ['id' => 5,'start_year' => '2025','end_year' => '2026', 'created_by' => 1],
        ];
        foreach ($sessions as $value) {
            Session::create($value);
        }
    }
}
