<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Response;
use App\Models\PrActivity;
use App\Models\StepMaster;
use App\Models\ProcessSteps;
use Illuminate\Http\Request;
use App\Models\MstLocalLevel;
use App\Base\Traits\ParentData;
use App\Base\BaseCrudController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Base\Traits\CheckPermission;
use App\Http\Requests\ResponseRequest;
use App\Base\Helpers\ResponseProcessHelper;
use App\Base\Helpers\RiskCalculationHelper;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ResponseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ResponseCrudController extends BaseCrudController
{   
    use ParentData;
    use CheckPermission;

    public function setup()
    {
        $this->crud->setModel('App\Models\Response');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/response');
        $this->crud->setEntityNameStrings(trans('response.title'), trans('response.title'));
        $this->data['script_js'] = $this->getScripsJs();
        if(backpack_user()){
        $this->checkPermission();  
        }    

        $mode = $this->crud->getActionMethod();

        if (in_array($mode,['edit','update'])){
            $response_id = $this->parent('id');
            $current_process_step_id  = Response::find($response_id)->process_step_id;
            $this->data['current_step_id'] = $current_process_step_id;
            $this->data['next_btn'] = true;
            $this->data['back_btn'] = true;

            $this->data['next_step_id'] = NULL;
            if($current_process_step_id == 4){
             
            }else{
                $next_step_id = ProcessSteps::whereStepId($current_process_step_id)->first()->next_step_id;

                $next_step_name = StepMaster::find($next_step_id)->name_lc;
                $this->data['next_step_id'] = $next_step_id;
            }
          
        }
    }

    public function getScripsJs(){
        return "
        $(document).ready(function(){
            $('.toBeHidden1').hide();
            $('.legend1').hide();
            $('.toBeHidden2').hide();
            $('.legend2').hide();

            $('input[name=gps_lat]').prop('readonly',true);
            $('input[name=gps_long]').prop('readonly',true);
            // $('input[type=map]').hide();


            var process_step_id = $('#process_step_id').val();

            console.log(process_step_id);

            if(process_step_id == 2){
                $('.toBeHidden').hide();
                $('.legend0').hide();
                $('.toBeHidden1').show();
                $('.legend1').show();
            }

            if(process_step_id == 3){
                $('.toBeHidden').hide();
                $('.legend0').hide();
                $('.toBeHidden1').hide();
                $('.legend1').hide();
                $('.toBeHidden2').show();
                $('.legend2').show();
            }

            if(process_step_id == 4){
                $('.toBeHidden').show();
                $('.legend0').show();
                $('.toBeHidden1').show();
                $('.legend1').show();
                $('.toBeHidden2').show();
                $('.legend2').show();
                $('.form-control').prop('disabled',true);
                $('form input[type=checkbox]').prop('readonly', true);
                $('form input[type=checkbox]').click(false);
                $('#map').click(false);
            }

            //js for autoloading lat and long from local_level
            $('input[name = ward_number]').on('blur',function(){
                var localLevelId = $('#local_level_id').val();
                var wardNo = $('input[name = ward_number]').val();
                    if(wardNo != null){
                    $.ajax({
                        type: 'GET',
                        url: '/response/getlatlong',
                        data: { localLevelId: localLevelId, wardNo: wardNo },
                        success: function(response) {
                            console.log(response);
                            if(response.message == 'success'){
                                $('#gps_lat').val(response.lat).trigger('change');
                                $('#gps_long').val(response.long).trigger('change');
                                changeLatDecimalToDegree();
                                changeLongDecimalToDegree();
                                // updateMarkerByInputs();
                            }
                            else if(response.message == 'fail'){
                                new Noty({
                                    type: 'warning',
                                    text: 'समस्या पर्यो'
                                }).show();
                            }
                        },
                        error: function(error) {}
                    });
                }else{
                    $('#gps_lat').val('').trigger('change');
                    $('#gps_long').val('').trigger('change');
                }
            });

            // show gps lat_long for country
            $('#country-id').on('change',function(){
                var countryId = $('#country-id').val();
                    if(countryId != null){
                    $.ajax({
                        type: 'GET',
                        url: '/response/getcapitallatlong',
                        data: { countryId: countryId },
                        success: function(response) {
                            console.log(response);
                            if(response.message == 'success'){
                                $('#gps_lat').val(response.country.cap_lat).trigger('change');
                                $('#gps_long').val(response.country.cap_long).trigger('change');
                                changeLatDecimalToDegree();
                                changeLongDecimalToDegree();
                                // updateMarkerByInputs();
                            }
                            else if(response.message == 'fail'){
                                new Noty({
                                    type: 'warning',
                                    text: 'समस्या पर्यो'
                                }).show();
                            }
                        },
                        error: function(error) {}
                    });
                }else{
                    $('#gps_lat').val('').trigger('change');
                    $('#gps_long').val('').trigger('change');
                }
            });

            //js for gismap

            changeLatDecimalToDegree();
            changeLongDecimalToDegree();

            if($('#gps_lat').val() == 0 && $('#gps_long').val() == 0){  
                // getLocation();

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else { 
                          alert('Your Browser does not support Geo-location.');
                    }  

                    function showPosition(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        // updateMarker(latitude, longitude);
                    }
       
            }else{
                // updateMarkerByInputs();
            }

            //Convert degree-minute-second to decimal
        
            $('#gps_lat_degree, #gps_lat_minute, #gps_lat_second').on('keyup', function() {
                var degree = parseInt($('#gps_lat_degree').val());
                var minute = parseInt($('#gps_lat_minute').val());
                var second = parseInt($('#gps_lat_second').val());
                $('#gps_lat').val(ConvertDMSToDD(degree, minute, second));
            });
        
            $('#gps_long_degree, #gps_long_minute, #gps_long_second').on('keyup', function() {
                var degree = parseInt($('#gps_long_degree').val());
                var minute = parseInt($('#gps_long_minute').val());
                var second = parseInt($('#gps_long_second').val());
                $('#gps_long').val(ConvertDMSToDD(degree, minute, second));
            });
        
            // Convert decimal to degree-minute-second
            $('#gps_lat').on('keyup', function() {
                changeLatDecimalToDegree();
                //  updateMarkerByInputs();
            });

        
            $('#gps_long').on('keyup', function() {
                changeLongDecimalToDegree();
                //  updateMarkerByInputs();

            });

 //By default hide the field and show in professionid choosen is 1           
            $('.legend-hide').hide();
            $('.agriculture-hide').hide();

            var professionId = $('#profession-id').val();
            if(professionId == 1){
                $('.legend-hide').show();
                $('.agriculture-hide').show();
                $('.agriculture-hide').prop('readonly',true);
            }

// show fields on change in profession
            $('#profession-id').on('change',function(){
                var professionId = $('#profession-id').val();

                if(professionId == 1){
                    $('.legend-hide').show();
                    $('.agriculture-hide').show();
                }else{
                    $('.legend-hide').hide();
                    $('.agriculture-hide').hide();
                }
            });
        });
        ";
    }

    protected function setupListOperation()
    {
        $cols = [
            $this->addRowNumber(),
            $this->addCodeColumn(),
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('response.name'),
                
            ],

            // [
            //     'name' => 'name_lc',
            //     'type' => 'text',
            //     'label' => trans('नाम'),
                
            // ],
            [
                'name'=>'local_address',
                'type' => 'model_function',
                'function_name' =>'local_address',
                'label'=>'Address',
            ],

            [
                'name' => 'age_risk_factor',
                'type' => 'text',
                'label' => 'Age Risk Factor',
            ],
            [
                'name' => 'covid_risk_index',
                'type' => 'text',
                'label' => 'COVID Risk Index',
            ],
            [
                'name' => 'probability_of_covid_infection',
                'type' => 'text',
                'label' => trans('Probability of').'<br>'.trans('COVID Infection '),
            ]
          
        ];
        $this->crud->addColumns($cols);
        $this->crud->orderBy('id');
   

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ResponseRequest::class);

        $language =App::getLocale();
        $lang = 'name_lc';
        if($language == "en"){
            $lang = 'name_en';
        }

        $mode = $this->crud->getActionMethod();
        $process_step_id = NULL;
        if(in_array($mode,['edit','update'])){
            $current_process_step_id  = Response::find($this->parent('id'))->process_step_id;

            $process_step_id = [
                'name' => 'process_step_id',
                'type' => 'hidden',
                'value' => Response::whereId($this->parent('id'))->first()->process_step_id,
                'attributes' => [
                    'id' => 'process_step_id'
                ],
            ];

        }

        $arr = [
            $process_step_id,
    
            // $this->addReadOnlyCodeField(),
            [
                'name' => 'code',
                'label' => trans('common.code'),
                'type' => 'hidden',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
                'attributes' => [
                    'readonly' => true,
                ],
            ],
            [
                'name' => 'info',
                'type' => 'custom_html',
                'value' =>'<div style="color:red; font-size:18px; font-weight:bold">'.trans('response.note_heading').'</div>'
            ],
            [
                'name' => 'legend1',
                'type' => 'custom_html',
                'value' => '',
            ],
            // [
            //     'name' => 'name_en',
            //     'type' => 'text',
            //     'label' => trans('Name'),
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-md-6 toBeHidden',
            //     ],
            // ],
            // [
            //     'name' => 'name_lc',
            //     'type' => 'text',
            //     'label' => trans('नाम'),
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-md-6 toBeHidden',
            //     ],
            // ],
            [
                'name' => 'age',
                'type' => 'number',
                'label' => trans('response.age'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
                'suffix' => 'years',
            ],

            [
                'name'=>'gender_id',
                'type'=>'select2',
                'label'=>trans('response.gender'),
                'entity'=>'gender',
                'model'=>'App\Models\MstGender',
                'attribute'=>$lang,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            // [
            //     'name' => 'email',
            //     'type' => 'text',
            //     'label' => trans('Email'),
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-md-12 toBeHidden',
            //     ],
            // ],
  
            [
                'name' => 'legend3',
                'type' => 'custom_html',
                'value' => '<b><legend>'.trans('response.address').'</legend></b>',
                'wrapperAttributes'=>[
                    'class' => 'legend0'
                ]
            ],

            [ //Toggle
                'name' => 'is_other_country',
                'label' => trans('response.is_other_country'),
                'type' => 'toggle',
                'options'     => [ 
                    0 => trans('response.nepal'),
                    1 => trans('response.others'),
                ],
                'inline' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-10 toBeHidden',
                ],
                'attributes' =>[
                    'id' => 'is_other_country',
                ],
                'hide_when' => [
                    0 => ['country_id','city'],
                    1 => ['province_id','district_id','local_level_id','ward_number'],
                ],
                'default' => 0,
            ],
            [
                'name'=>'province_id',
                'type'=>'select2',
                'label'=>trans('response.province'),
                'entity'=>'province',
                'model'=>'App\Models\MstProvince',
                'attribute'=>$lang,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name'=>'district_id',
                'label'=>trans('response.district'),
                'type'=>'select2_from_ajax',
                'model'=>'App\Models\MstDistrict',
                'entity'=>'district',
                'attribute'=>$lang,
                'data_source' => url("api/district/province_id"),
                'placeholder' => "Select a District",
                'minimum_input_length' => 0,
                'dependencies'         => ['province_id'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name'=>'local_level_id',
                'label'=>trans('response.locallevel'),
                'type'=>'select2_from_ajax',
                'entity'=>'locallevel',
                'model'=>'App\Models\MstLocalLevel',
                'attribute'=>$lang,
                'data_source' => url("api/locallevel/district_id"),
                'placeholder' => "Select a Local Level",
                'minimum_input_length' => 0,
                'dependencies'         => ['district_id'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'local_level_id',
                ]
            ],
            [
                'name'=>'ward_number',
                'type'=>'number',
                'label'=>trans('response.ward'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
                'attributes'=> [
                    'id' => 'ward_num',
                ]
            ],
            [
                'name'=>'country_id',
                'type'=>'select2',
                'label'=>trans("response.country"),
                'entity'=>'country',
                'model'=>'App\Models\Country',
                'attribute'=>$lang,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
                'attributes'=> [
                    'id'=> 'country-id',
                ]
            ],

            [
                'name'=>'city',
                'type'=>'text',
                'label'=>trans('response.city'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
                'attributes'=> [
                    'id' => 'city',
                ]
            ],

            [
                'name' => 'legend4',
                'type' => 'custom_html',
                'value' => '<b><legend>'.trans('response.gps_coordinates').'</legend></b>',
                'wrapperAttributes'=>[
                    'class' => 'legend0'
                ]
            ],
            [
                'name' => 'separater1',
                'type' => 'custom_html',
                'value' => '<h5><b><span style="position: relative; top:23px;">'.trans('response.latitude').'</span></b></h5>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
            ],
    
            [
                'name' => 'gps_lat',
                'label' => trans('response.decimal_degree_latitude'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3 toBeHidden',
                ],
                'attributes' => [
                    'step' => 'any',
                    'id' => 'gps_lat',
                ],
                'default' => '0',
                'readonly'=>true,
            ],
            [
                'name' => 'separater2',
                'type' => 'custom_html',
                'value' => '<h5><b><span style="position: relative; top:23px;">'.trans('response.longitude').'</span></b></h5>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
            ],

            [
                'name' => 'gps_long',
                'label' => trans('response.decimal_degree_longitude'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3 toBeHidden',
                ],
                'attributes' => [
                    'step' => 'any',
                    'id' => 'gps_long',
                ],
                'default' => '0',
            ],

            // [
            //     'name' => 'map',
            //     'type' => 'map',
            // ],



            [
                'name' => 'legend50',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.occupation_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.occupation_label').'</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'occupation',
                'entity'    => 'occupation',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(1)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],
            ],
            [
                'name' => 'legend5',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.exposure_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.exposure_label').'</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'exposure',
                'entity'    => 'exposure',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(2)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],
            ],


            [
                'name' => 'legend6',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.safety_measure_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.do_you').'</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'safety_measure',
                'entity'    => 'safety_measure',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(3)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],
            ],


            [
                'name' => 'legend7',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.habits_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.do_you').'</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'habits',
                'entity'    => 'habits',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(4)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],
            ],


            [
                'name' => 'legend8',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.health_condition_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.health_condition_label').'</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'health_condition',
                'entity'    => 'health_condition',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(5)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],
            ],


            [
                'name' => 'legend9',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.symptom_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.symptom_label').'</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'symptom',
                'entity'    => 'symptom',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(6)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],

            ],
            
            [
                'name' => 'legend11',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.community_situation_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]                
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.community_situation_label').'</b>',
                'type'      => 'select2',
                'name'      => 'community_situation',
                'entity'    => 'community_situation',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(8)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1'
                ],
                'attributes'=> [
                    'id' => 'community-situation',
                ],
            ], 
            [
                'name' => 'legend12',
                'type' => 'custom_html',
                'value' => '<legend>Economic Impact</legend>',
                'value' => '<legend>'.trans('response.economic_impact_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b><span style="color:red;">* </span>'.trans('response.economic_impact_label').'</b>',
                'type'      => 'select2',
                'name'      => 'economic_impact',
                'entity'    => 'economic_impact',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(9)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1'
                ], 
                'attributes'=> [
                    'id' => 'economic-impact',
                ],
            ],

            [
                'name' => 'legend2',
                'type' => 'custom_html',
                'value' => '<b><legend>'.trans('response.education_profession_title').'</legend></b>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ],
            ],
          
            [
                'name'=>'education_id',
                'type'=>'select2',
                'label'=>'<b>'.trans('response.education').'</b>',
                'entity'=>'education',
                'model'=>'App\Models\MstEducationalLevel',
                'attribute'=>$lang,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2',
                ],
            ],
            [
                'name'=>'profession_id',
                'type'=>'select2',
                'label'=>'<b>'.trans('response.profession').'</b>',
                'entity'=>'profession',
                'model'=>'App\Models\MstProfession',
                'attribute'=>$lang,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2',
                ],
                'attributes'=>[
                    'id' => 'profession-id'
                ],
            ],

            [
                'name' => 'legend10',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.neighbour_proximity_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]  
            ],

            [
                'label'     => '<b>'.trans('response.neighbour_proximity_label').'</b>',
                'type'      => 'select2',
                'name'      => 'neighbour_proximity',
                'entity'    => 'neighbour_proximity',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(7)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],

         
            [
                'name' => 'legend13',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.confirmed_case_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.confirmed_case_label').'</b>',
                'type'      => 'select2',
                'name'      => 'confirmed_case',
                'entity'    => 'confirmed_case',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(10)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],

            [
                'name' => 'legend14',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.inbound_foreign_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.inbound_foreign_label').'</b>',
                'type'      => 'select2',
                'name'      => 'inbound_foreign_travel',
                'entity'    => 'inbound_foreign_travel',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(11)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]            ],


            [
                'name' => 'legend15',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.community_population_title').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.community_population_label').'</b>',
                'type'      => 'select2',
                'name'      => 'community_population',
                'entity'    => 'community_population',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(12)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]            
            ],


            [
                'name' => 'legend16',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.hospital_proximity_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.hospital_proximity_title').'</b>',
                'type'      => 'select2',
                'name'      => 'hospital_proximity',
                'entity'    => 'hospital_proximity',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(13)->get();
                }),
               'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend17',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.corona_centre_proximity_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.corona_centre_proximity_title').'</b>',
                'type'      => 'select2',
                'name'      => 'corona_centre_proximity',
                'entity'    => 'corona_centre_proximity',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(14)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend18',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.health_facility_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.health_facility_title').'</b>',
                'type'      => 'select2',
                'name'      => 'health_facility',
                'entity'    => 'health_facility',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(15)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend19',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.market_proximity_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.market_proximity_title').'</b>',
                'type'      => 'select2',
                'name'      => 'market_proximity',
                'entity'    => 'market_proximity',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(16)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend20',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.food_stock_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.food_stock_title').'</b>',
                'type'      => 'select2',
                'name'      => 'food_stock',
                'entity'    => 'food_stock',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(17)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend21',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.agri_producer_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend-hide'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.agri_producer_title').'</b>',
                'type'      => 'select2',
                'name'      => 'agri_producer_seller',
                'entity'    => 'agri_producer_seller',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(18)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 agriculture-hide'
                ]
            ],


            [
                'name' => 'legend22',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.product_selling_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend-hide'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.product_selling_title').'</b>',
                'type'      => 'select2',
                'name'      => 'product_selling_price',
                'entity'    => 'product_selling_price',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(19)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 agriculture-hide'
                ]
            ],


            [
                'name' => 'legend23',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.commodity_availability_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.commodity_availability_title').'</b>',
                'type'      => 'select2',
                'name'      => 'commodity_availability',
                'entity'    => 'commodity_availability',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(20)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend24',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.commodity_price_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.commodity_price_title').'</b>',
                'type'      => 'select2',
                'name'      => 'commodity_price_difference',
                'entity'    => 'commodity_price_difference',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(21)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],

            [
                'name' => 'legend25',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.job_status_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.job_status_title').'</b>',
                'type'      => 'select2',
                'name'      => 'job_status',
                'entity'    => 'job_status',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(22)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend26',
                'type' => 'custom_html',
                'value' => '<legend>'.trans('response.sustainability_label').'</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>'.trans('response.sustainability_title').'</b>',
                'type'      => 'select2',
                'name'      => 'sustainability_duration',
                'entity'    => 'sustainability_duration',
                'attribute' => $lang,
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(23)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden2'
                ]
            ],


            // [
            //     'name' => 'legend27',
            //     'type' => 'custom_html',
            //     'value' => '',
            // ],
            // [
            //     'name' => 'remarks',
            //     'label' => trans('response.remarks'),
            //     'type' => 'textarea',
            //     'wrapperAttributes' => [
            //         'class' => 'form-group col-md-12 toBeHidden'
            //     ]
            // ]


        ];
        $arr = array_filter($arr);
        $this->crud->addFields($arr);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function updatefinalstep($id){
         Response::whereId($id)->update(['process_step_id' => 4]);

         return redirect(url('/'));
    }

    public function nextstep($id){
     
        $request = $this->crud->validateRequest();
        ResponseProcessHelper::updateProcess($id, $request,'next');

        $response = Response::find($id);
        $process_step_id = $response->process_step_id;

        if($process_step_id == 3){
            $risk_calculation = new RiskCalculationHelper();
            $risk_calculation->calculate_risk($id);

            request()->session()->put('is_calculated','true');

            return redirect(url('/'));
        }

        if(backpack_user()){
            if($process_step_id == 4){
                return redirect(backpack_url('/'));
            }else{
                return redirect(backpack_url('/response').'/'.$id.'/edit');
            }
        }else{
            if($process_step_id == 4){
                return redirect(url('/'));
            }else{
                return redirect(url('/public/fill_response').'/'.$id.'/edit');
            }
        }
    }

    public function backstep($id){
     
    ResponseProcessHelper::updateProcess($id,$request=NULL,'back');

    if(backpack_user()){
        return redirect(backpack_url('/response').'/'.$id.'/edit');
    }else{
        return redirect(url('/public/fill_response').'/'.$id.'/edit');
    }
    }

    
    public function store()
    {
        // $this->crud->hasAccessOrFail('create');
         $request = $this->crud->validateRequest();
        // execute the FormRequest authorization and validation, if one is required
        if($request->has('code')){
            if(trim($request->get('code')) == ''){
                $qu = DB::table($this->crud->model->getTable())
                    ->selectRaw('COALESCE(max(code::NUMERIC),0)+1 as code')
                    ->whereRaw("(code ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$') = true");
            
                $rec = $qu->first();
                if(isset($rec)){
                    $code = $rec->code;
                }
                else{
                    $code = 1;
                }
                request()->request->set('code', $code);
            }
        }
            $lat = request()->request->get('gps_lat');
            $long = request()->request->get('gps_long');

            if($lat == 0 || $long == 0){
                $local_level_id = $request->local_level_id;

                $local_level_code = MstLocalLevel::whereId($local_level_id)->pluck('code')->first();
                
                $lat = DB::table('mst_ward')->where('local_level_code',$local_level_code)->pluck('lat_municipal')->first();
                $long = DB::table('mst_ward')->where('local_level_code',$local_level_code)->pluck('long_municipal')->first();
            }

            $random = $this->generateRandomNum(0,9);
            $gps_lat = (float)$lat+(float)$random;
            $gps_long = (float)$long+(float)$random;

            request()->request->set('gps_lat',$gps_lat);
            request()->request->set('gps_long',$gps_long);

        if(!backpack_user()){
            $itemId = $this->saveRequest($request);

            request()->session()->put('response_id',$itemId);

            \Alert::success(trans('Data Submitted Successfully'))->flash();
            return redirect(url('/public/fill_response').'/'.$itemId.'/edit');
        }else{

           // insert item in the db
            DB::beginTransaction();
            try {
                $item = $this->crud->create($this->crud->getStrippedSaveRequest());
                $this->data['entry'] = $this->crud->entry = $item;

                $itemId = $item->id;
                request()->session()->put('response_id',$itemId);

        
                //getting first process step for process type-bill
                $firstProcessStep = ProcessSteps::whereIsFirstStep(true)->first();

                //Updating the PsBill for process event
                Response::whereId($itemId)->update([
                    'process_step_id' => 2,
                    'user_id' => backpack_user()->id,
                ]);

                DB::commit();

            } catch (\Throwable $th) {
                DB::rollback();
                dd($th);
            }
                // show a success message
            \Alert::success(trans('Data Submitted Successfully'))->flash();
            return redirect(backpack_url('/response').'/'.$itemId.'/edit');
        }
    }

    public function saveRequest($request){

        $is_other_country = $request->is_other_country;

        if($is_other_country == 0){
        $request->validate([
            // 'name_lc' => 'required|max:255',
            'age' => 'required|min:1|max:3',
            'gender_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'local_level_id' => 'required',
            'ward_number' => 'required|min:1|max:2',
        ]);
        }else{
            $request->validate([
                // 'name_lc' => 'required|max:255',
                'age' => 'required|min:1|max:3',
                'gender_id' => 'required',
                'country_id'=> 'required',
                'city'=> 'required',
            ]);

        }

        $dataSet = [
        'code' => $request->code,
        // 'name_en' => $request->name_en,
        // 'name_lc' => $request->name_lc,
        'age' => $request->age,
        'gender_id' => $request->gender_id,
        'email' => $request->email,
        'is_other_country'=> $request->is_other_country,
        'country_id'=> $request->country_id,
        'city'=> $request->city,
        'province_id' => $request->province_id,
        'district_id' => $request->district_id,
        'local_level_id' => $request->local_level_id,
        'ward_number' => $request->ward_number,
        'remarks' => $request->remarks,
        'created_at'=> Carbon::now()->todatetimestring(),
        ];
        //add random number to gps lat and long to make difference in co-ordinates
        $lat = $request->gps_lat;
        $long = $request->gps_long;

        if($lat == 0 || $long == 0){
            $local_level_id = $request->local_level_id;

            $local_level_code = MstLocalLevel::whereId($local_level_id)->pluck('code')->first();
            
            $lat = DB::table('mst_ward')->where('local_level_code',$local_level_code)->pluck('lat_municipal')->first();
            $long = DB::table('mst_ward')->where('local_level_code',$local_level_code)->pluck('long_municipal')->first();
        }

        $random = $this->generateRandomNum(0,9);
        $gps_lat = (float)$lat+(float)$random;
        $gps_long = (float)$long+(float)$random;

        $dataSet['gps_lat'] = $gps_lat;
        $dataSet['gps_long'] = $gps_long;

        DB::beginTransaction();
        try {
            
            $itemId = DB::table('response')->insertGetId($dataSet);
            //getting first process step for process type-bill
            $firstProcessStep = ProcessSteps::whereIsFirstStep(true)->first();

            //Updating the PsBill for process event
            Response::whereId($itemId)->update([
                'process_step_id' => 2,
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }

        return $itemId;

    }

    public function generateRandomNum($a,$b){
        $float_part = mt_rand(0, mt_getrandmax())/mt_getrandmax();
        $number = explode('.',$float_part);
        $num = substr($number[1],0,3);
        $i = '0.0000';
        $random = $i.$num;
    return $random;
    }

    public function fetchLatLong(Request $request){
        $localLevelId = $request->localLevelId;
        $ward_no = $request->wardNo;

        $local_level = MstLocalLevel::find($localLevelId);
        
        $ward_info = DB::table('mst_ward')->where([['local_level_code',$local_level->code],['ward',$ward_no]])->get();
        if($ward_info->count()>0){;
            $ward_info = $ward_info[0];
            $lat = $ward_info->lat_ward;
            $long = $ward_info->long_ward;
          
        }else{
            $local_level_info = MstLocalLevel::where('id',$localLevelId)->get()->first();
            $lat = $local_level_info->gps_lat;
            $long = $local_level_info->gps_long;
        }

        return response()->json([
            'message' => 'success',
            'lat' => $lat,
            'long' => $long,
        ]);    
    }

  
    public function fetchCapitalLatLong(Request $request){
        $countryId = $request->countryId;

        $country = DB::table('mst_country')->where('id',$countryId)->get()->first();
        
         if($country){
            return response()->json([
                'message' => 'success',
                'country' => $country
            ]);
        }else{
            return response()->json([
                'message' => 'fail',
            ]);
        }
    }
}
