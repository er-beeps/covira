<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.


// api routes
Route::get('api/district/{province_id}', 'App\Http\Controllers\api\ProvinceDistrictController@index');
Route::get('api/locallevel/{district_id}', 'App\Http\Controllers\api\DistrictLocalLevelController@index');

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    //primary master routes
    Route::crud('province', 'MstProvinceCrudController');
    Route::crud('district', 'MstDistrictCrudController');
    Route::crud('localleveltype', 'MstLocalLevelTypeCrudController');
    Route::crud('locallevel', 'MstLocalLevelCrudController');
    Route::crud('nepalimonth', 'MstNepaliMonthCrudController');
    Route::crud('fiscalyear', 'MstFiscalYearCrudController');
    Route::crud('gender', 'MstGenderCrudController');
    Route::crud('educationallevel', 'MstEducationalLevelCrudController');
    Route::crud('profession', 'MstProfessionCrudController');

    //seconday master routes
    Route::crud('prhospital', 'PrHospitalCrudController');
    Route::crud('prquarantinecenter', 'PrQuarantineCenterCrudController');
    Route::crud('prfactor', 'PrFactorCrudController');
    Route::crud('practivity', 'PrActivityCrudController');


    Route::crud('response', 'ResponseCrudController');
    
}); // this should be the absolute last line of this file