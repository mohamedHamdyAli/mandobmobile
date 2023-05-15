<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('settings')->insert([
            'id' =>  1,
            'name_en' =>  'mandob',
            'name_ar' =>  'مندوب',
            'description_en' =>  'mandob description',
            'description_ar' =>  'وصف مندوب',
            'facebook_url' =>  '',
            'twitter_url' =>  '',
            'linkedin_url' =>  '',
            'linkedin_url' =>  '',
            'instgram_url' =>  '',
            'youtube_url' =>  '',
            'Help_number' =>  '',
            'email' =>  '',
            'currency' =>  '',
        ]);
    }
}
