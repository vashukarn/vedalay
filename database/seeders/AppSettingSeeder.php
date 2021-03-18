<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    public function run()
    {
        $address = ['Agra','Mathura'];
        $email = ['hello@vedyalay.com','jaykarvashu@gmail.com'];
        AppSetting::create([
            'id' => 1,
            'name' => 'Vedyalay School Management System',
            'address' => $address,
            'email' => $email,
            'current_session' => 1,
            'logo' => 'https://vedyalay.com/assets/img/logo.png',
            'logo_light' => 'https://vedyalay.com/assets/img/logo-light.png',
            'favicon' => 'https://vedyalay.com/assets/img/favicon.png',
        ]);
    }
}
