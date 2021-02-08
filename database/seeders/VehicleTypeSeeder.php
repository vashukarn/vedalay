<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
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
                'type' => 'Car',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'type' => 'Auto',
                'status' => 'active'
            ],
            [
                'id' => 3,
                'type' => 'Van',
                'status' => 'active'
            ],
            [
                'id' => 4,
                'type' => 'Moter Bike',
                'status' => 'active'
            ],
            // [
            //     'type' => 'Bicycle', 
            // 'status' => 'active'
            // ],

        ];
        \DB::table('vehicle_types')->insert($data);
    }
}
