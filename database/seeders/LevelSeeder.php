<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['id' => 1,'standard' => 'One','section' => 'I'],
            ['id' => 2,'standard' => 'One','section' => 'II'],
            ['id' => 3,'standard' => 'One','section' => 'III'],
            ['id' => 4,'standard' => 'Two'],
            ['id' => 5,'standard' => 'Three'],
            ['id' => 6,'standard' => 'Four'],
            ['id' => 7,'standard' => 'Five'],
        ];
        foreach ($levels as $key => $value) {
            Level::create($value);
        }
    }
}
