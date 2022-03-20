<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('painting/{id}', "App\Http\Controllers\PaintingController@getPaintingById");
Route::get('get-all-paintings', "App\Http\Controllers\PaintingController@getAllPaintings");
Route::get('exhibition/{id}', "App\Http\Controllers\ExhibitionController@getExhibitionById");
Route::get('get-all-exhibitions', "App\Http\Controllers\ExhibitionController@getAllExhibitions");
Route::get('get-all-genres',"App\Http\Controllers\GenreController@getAllGenres");
Route::get('genre/{id}',"App\Http\Controllers\GenreController@getAllPaintingsByGenre");

Route::get('/', "App\Http\Controllers\SettingsController@getSiteInfo");
Route::post("artist/{id}/painting/create", "App\Http\Controllers\PaintingController@store");

//artists
Route::get('artist/{id}', "App\Http\Controllers\ArtistController@getArtistById");
Route::get('get-all-artists', "App\Http\Controllers\ArtistController@getAllArtists");
Route::get('artist/{id}/get-all-exhibitions', "App\Http\Controllers\ArtistController@getAllExhibitions");
//Authentication
Route::post("register", "App\Http\Controllers\AuthController@register");
