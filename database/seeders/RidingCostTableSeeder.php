<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RidingCostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'base_distance' => 1, 
                'base_cost' => 50, 
                'unit_cost' => 50, 
                'status' => 'active', 
                'extra_time_unit' => 10, 
                'extra_time_cost' => 20, 
                'night_cost' => 20, 
                'vehicle_type_id' => 1, 
                'city' => 'Kathmandu Nepal'
            ], 
            [
                'id' => 2,
                'base_distance' => 1, 
                'base_cost' => 30, 
                'unit_cost' => 30, 
                'status' => 'active', 
                'extra_time_unit' => 10, 
                'extra_time_cost' => 20, 
                'night_cost' => 25, 
                'vehicle_type_id' => 2, 
                'city' => 'Kathmandu Nepal'
            ],
            [
                'id' => 3,
                'base_distance' => 1, 
                'base_cost' => 40, 
                'unit_cost' => 40, 
                'status' => 'active', 
                'extra_time_unit' => 10, 
                'extra_time_cost' => 20, 
                'night_cost' => 30, 
                'vehicle_type_id' => 3, 
                'city' => 'Kathmandu Nepal'
            ],
            [
                'id' => 4,
                'base_distance' => 1, 
                'base_cost' => 60, 
                'unit_cost' => 60, 
                'status' => 'active', 
                'extra_time_unit' => 10, 
                'extra_time_cost' => 20, 
                'night_cost' => 35, 
                'vehicle_type_id' => 4, 
                'city' => 'Kathmandu Nepal'
            ],
        ];
        \DB::table('riding_costs')->insert($data);
    }
}
