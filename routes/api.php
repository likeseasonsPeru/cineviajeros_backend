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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::apiResources([
    'peliculas' => 'PeliculaController', 
    'combos' => 'ComboController',
    'promotions' => 'PromotionController',
    'horarios' => 'HorarioController',
    'banners' => 'BannerController'
], ["middleware" => ["apikey.validate", "cors"]]);

Route::group(["middleware" => ["apikey.validate", "cors"]], function () {
    Route::get('promotionpage', 'ExtraRoutesController@promotion');
    Route::get('peliculaspage', 'ExtraRoutesController@peliculas');
    Route::get('horariosPelicula/{id}', 'ExtraRoutesController@horariosByPelicula');
    Route::get('peliculaCategory/{category}', 'ExtraRoutesController@peliculasByCategoria');
});