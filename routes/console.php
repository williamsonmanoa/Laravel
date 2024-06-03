<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

//
//Route::group([
//    'prefix' => config('backpack.base.route_prefix', 'admin'),
//    'middleware' => array_merge(
//        (array) config('backpack.base.web_middleware', 'web'),
//        (array) config('backpack.base.middleware_key', 'admin')
//    ),
//    'namespace' => 'App\Http\Controllers\Equipe',
//], function () { // custom admin routes
//    Route::crud('resultat', 'EquipeResultatController');
//}); // this should be the absolute last line of this file
