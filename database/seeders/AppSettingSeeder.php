<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run()
    {
        $address = ['+917070675425','+9779845850197'];
        $address = ['+917070675425','+9779845850197'];
        AppSetting::create([
            'id' => 1,
            'name' => 'Vedyalay School Management System',
            'address' => $address,
            'address' => $address,
        ]);
    }
}
