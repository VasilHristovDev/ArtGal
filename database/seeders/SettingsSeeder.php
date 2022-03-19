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
            'key' => 'name',
            'name' => 'Website Name',
            'description' => 'The name of the website',
            'value' => 'ArtGal',
            'field' => '{"name":"value","label":"Value","type":"tinymce"}',
            'active' => 1
        ]);

        DB::table('settings')->insert([
            'key' => 'description',
            'name' => 'Website Description',
            'description' => 'The description of the website',
            'value' => 'Our website aims to make art popular among more and more people. We value small artists and want to help them show their art to the world!',
            'field' => '{"name":"value","label":"Value","type":"tinymce"}',
            'active' => 1
        ]);
    }
}
