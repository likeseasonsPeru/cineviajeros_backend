<?php

use App\Http\Controllers\SubscriptionController;
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
], ["middleware" => ["jwt.verify", "cors"]]);


Route::group(["middleware" => ["cors"]], function () {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@authenticate');
    Route::post('subscriptionsAdd', 'SubscriptionController@store');
});


Route::group(["middleware" => ["apikey.validate", "cors"]], function () {
    Route::get('promotionpage', 'ExtraRoutesController@promotion');
    Route::get('peliculaspage', 'ExtraRoutesController@peliculas');
    Route::get('combospage', 'ExtraRoutesController@combo');
    Route::get('horariosPelicula/{id}', 'ExtraRoutesController@horariosByPelicula');
    Route::get('peliculaCategory/{category}', 'ExtraRoutesController@peliculasByCategoria');
    Route::post('peliculasByFilter', 'ExtraRoutesController@peliculasByFilter');
    Route::get('orderTable/{table}', 'ExtraRoutesController@orderTable');
});

Route::group(["middleware" => ["apikey.validate", "cors"]], function () {
    Route::get('peliculas', 'PeliculaController@index');
    Route::get('combos', 'ComboController@index');
    Route::get('promotions', 'PromotionController@index');
    Route::get('horarios', 'HorarioController@index');
    Route::get('banners', 'BannerController@index');
    Route::get('subscriptions', 'SubscriptionController@index');
    /* Route::get('subscriptions', 'SubscriptionController@index'); */
    Route::get('peliculas/{pelicula}', 'PeliculaController@show');
    Route::get('combos/{combo}', 'ComboController@show');
    Route::get('promotions/{promotion}', 'PromotionController@show');
    Route::get('horarios/{horario}', 'HorarioController@show');
    Route::get('banners/{banner}', 'BannerController@show');
    Route::get('subscriptions/{subscription}', 'SubscriptionController@show');
    Route::get('allpeliculas', 'ExtraRoutesController@allpeliculas');
    Route::get('claim', 'ClaimedController@index');
    Route::post('claim', 'ClaimedController@store');
});


Route::group(["middleware" => ["jwt.verify", "cors"]], function () {
    Route::post('sortUpdate/{table}', 'ExtraRoutesController@sortUpdatePeliculas');
    /* Route::post('sortPromociones', 'ExtraRoutesController@authenticate');
    Route::post('sortCombos', 'ExtraRoutesController@store');
    Route::post('sortBanners', 'ExtraRoutesController@store'); */
    
});