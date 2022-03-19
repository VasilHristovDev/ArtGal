<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('settings')->insert([
            'key' => 'logo',
            'name' => 'Website Logo',
            'description' => 'The logo of the website',
            'value' => 'http://artgal-amigos-bg.site/storage/logo_artgal.png',
            'field' => '{"name":"value","label":"Value","type":"tinymce"}',
            'active' => 1
        ]);

    }
}
