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
    'prefix'     => 'public',
    'middleware' => ['web'],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {

    Route::post('/response/store', 'ResponseCrudController@store');
    Route::crud('fill_response', 'ResponseCrudController');
    // Route::post('/searchregionalrisk', 'GisMapController@getRegionalRisk');
});

Route::group([
    'middleware' => ['web'],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    Route::put('/response/{response_id}/nextstep', 'ResponseCrudController@nextstep');
    Route::get('/response/{response_id}/backstep', 'ResponseCrudController@backstep');
    Route::get('/response/{response_id}/updatefinalstep', 'ResponseCrudController@updatefinalstep');

    Route::get('/response/getlatlong', 'ResponseCrudController@fetchLatLong');
    Route::get('/response/getcapitallatlong', 'ResponseCrudController@fetchCapitalLatLong');
    Route::crud('/respondantdata', 'RespondentDataCrudController');
});


Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    //primary master routes
    Route::crud('country', 'CountryCrudController');
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
    Route::put('response/{response_id}/nextstep', 'ResponseCrudController@nextstep');
    Route::get('response/{response_id}/backstep', 'ResponseCrudController@backstep');
    
    Route::crud('respondantdata', 'RespondentDataCrudController');

    // Route::crud('stepmaster', 'StepMasterCrudController');
    // Route::crud('processsteps', 'ProcessStepsCrudController');
    Route::crud('nepaldatacovid', 'NepalDataCovidCrudController');
    Route::crud('uploadimage', 'ImageUploadCrudController');
    Route::crud('imagecategory', 'ImageCategoryCrudController');
    Route::crud('import', 'ImportCrudController');

    Route::post('import_excel', 'ImportCrudController@import');
    Route::get('export_response_excel', 'ImportCrudController@exportResponseExcel');
    Route::get('export_searchrisk_excel', 'ImportCrudController@exportSearchRiskExcel');
    
    //scrap
}); // this should be the absolute last line of this file