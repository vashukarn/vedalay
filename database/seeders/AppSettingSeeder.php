<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            "website_content_format" => "Nepali",
// "website_content_item"
        ];
        \DB::table('app_settings')->insert($data);
    }
}
