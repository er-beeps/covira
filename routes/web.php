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
Route::get('/admin', 'Auth\LoginController@showLoginForm');


Route::get('/', 'GisMapController@index');
Route::get('/gismap', 'GisMapController@index');
Route::get('/admin/gismap', 'GisMapController@index');
Route::get('/home', 'GisMapController@index');
Route::get('/district/{id}', 'DependentDropdownController@getdistrict');
Route::get('/local_level/{id}', 'DependentDropdownController@getlocal_level');
Route::post('/response/store', 'Admin\ResponseCrudController@store');

Route::put('/response/{response_id}/nextstep', 'Admin\ResponseCrudController@nextstep');
Route::put('/response/{response_id}/updatefinalstep', 'Admin\ResponseCrudController@updatefinalstep');
Route::get('/response/{response_id}/backstep', 'Admin\ResponseCrudController@backstep');
Route::get('/response/getlatlong', 'Admin\ResponseCrudController@fetchLatLong');
Route::get('/response/getcapitallatlong', 'Admin\ResponseCrudController@fetchCapitalLatLong');
Route::crud('/respondantdata', 'Admin\RespondentDataCrudController');

Route::post('/dashboard/incrementlike', 'GisMapController@incrementLike');
Route::post('/dashboard/incrementdislike', 'GisMapController@incrementDislike');

Route::get('/response/fetchimages', 'GisMapController@fetchImg');
Route::get('/response/view_result', 'Admin\ResponseCrudController@redirectResult');

Route::post('/searchregionalrisk', 'GisMapController@getRegionalRisk');


// Route::get('/response/fetchimages/publichealth', 'GisMapController@publichealthImg');
// Route::get('/response/fetchimages/foodproductivity', 'GisMapController@foodproductivityImg');
// Route::get('/response/fetchimages/transmissionrisk', 'GisMapController@transmissionImg');
// Route::get('/response/fetchimages/overallrisk', 'GisMapController@overallriskImg');


 