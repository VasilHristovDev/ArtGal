<?php

namespace App\Console\Commands;

use App\Models\Painting;
use Backpack\Settings\app\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GeneratePaintingOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:painting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates painting of the day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $oldPainting = json_decode(Setting::get('painting_of_the_day'));
            $painting = Painting::all()->inRandomOrder()->first();
            $count = Painting::all()->count();
            if ($oldPainting && $painting) {
                while ($oldPainting->id == $painting->id && $count > 1) {
                    $painting = Painting::all()->inRandomOrder()->first();
                }
            }
            if ($painting) {
                Setting::set('painting_of_the_day', [
                    'id' => $painting->id,
                    'name' => $painting->name,
                    'genre' => $painting->genre(),
                    'gallery' => $painting->images(),
                    'user' => $painting->userData(),
                ]);
            }
        } catch (\Exception $exception) {
            Log::error(Carbon::now() . " " . $exception->getMessage());
        }
    }
}
