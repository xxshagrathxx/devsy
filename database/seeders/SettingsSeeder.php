<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [[
            'key' => 'copyrights_en',
            'value' => '2023 All Rights Reserved',
        ],[
            'key' => 'copyrights_ar',
            'value' => '2023 كل الحقوق محفوظة',
        ],[
            'key' => 'copyrights_en_lnk',
            'value' => 'Devsy',
        ],[
            'key' => 'copyrights_ar_lnk',
            'value' => 'Devsy',
        ],[
            'key' => 'copyrights_lnk',
            'value' => 'https://devsy.tech/',
        ],[
            'key' => 'logo',
            'value' => 'logo.png',
        ],[
            'key' => 'favicon',
            'value' => 'favicon.png',
        ],[
            'key' => 'contact_us_to_email',
            'value' => 'contact@dev.net',
        ],[
            'key' => 'contact_us_subject',
            'value' => 'Mail from Devsy Contact Us',
        ]];

        foreach($settings as $setting){
            Settings::create($setting);
        }
    }
}
