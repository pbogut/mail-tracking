<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AuthToken;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/image/{messageId}.gif', 'App\Http\Controllers\HitController@pixel');

// simple api
Route::get('/rest/hitlog', 'App\Http\Controllers\HitController@hitlog')
    ->middleware(AuthToken::class);
Route::get('/rest/summary/{messageId}', 'App\Http\Controllers\HitController@summary')
    ->middleware(AuthToken::class);
