<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $sessions = [
            ['id' => 1,'title' => 'Astro Physics','type' => 'Theory','value' => 'Compulsory','publish_status' => '1','level_id' => '1'],
            ['id' => 2,'title' => 'Quantum Physics','type' => 'Theory','value' => 'Compulsory','publish_status' => '1','level_id' => '1'],
            ['id' => 3,'title' => 'Mechanics','type' => 'Theory','value' => 'Compulsory','publish_status' => '1','level_id' => '1'],
            ['id' => 4,'title' => 'Optics','type' => 'Theory','value' => 'Compulsory','publish_status' => '1','level_id' => '1'],
            ['id' => 5,'title' => 'C++','type' => 'Theory','value' => 'Compulsory','publish_status' => '1','level_id' => '1'],
        ];
        foreach ($sessions as $value) {
            Subject::create($value);
        }
    }
}
