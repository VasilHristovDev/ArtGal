<?php

namespace App\Http\Controllers;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getSettings()
    {
        return Setting::all();
    }

    public function getSiteInfo()
    {
        return [
//            'logo' => Setting::get('logo'),
            'name' => Setting::get('name'),
            'description' => Setting::get('description'),
        ];
    }
}
