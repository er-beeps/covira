<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'GisMapController@index');
Route::get('/gismap', 'GisMapController@index');
Route::get('/admin/gismap', 'GisMapController@index');
Route::get('/home', 'GisMapController@index');
Route::get('/district/{id}', 'DependentDropdownController@getdistrict');
Route::get('/local_level/{id}', 'DependentDropdownController@getlocal_level');
Route::post('/response/store', 'Admin\ResponseCrudController@store');

    Route::put('/response/{response_id}/nextstep', 'Admin\ResponseCrudController@nextstep');
    Route::get('/response/{response_id}/backstep', 'Admin\ResponseCrudController@backstep');
    Route::crud('/respondantdata', 'Admin\RespondentDataCrudController');
