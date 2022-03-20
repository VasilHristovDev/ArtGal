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
            'key' => 'painting_of_the_day',
            'name' => 'Painting of the day',
            'description' => 'Random painting',
            'value' => '',
            'field' => '{"name":"value","label":"Value","type":"tinymce"}',
            'active' => 1
        ]);

    }
}
