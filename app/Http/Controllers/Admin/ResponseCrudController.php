<?php

namespace App\Http\Controllers\Admin;

use App\Models\Response;
use App\Models\PrActivity;
use App\Models\StepMaster;
use App\Models\ProcessSteps;
use Illuminate\Http\Request;
use App\Models\MstLocalLevel;
use App\Base\Traits\ParentData;
use App\Base\BaseCrudController;
use Illuminate\Support\Facades\DB;
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

    public function setup()
    {
        $this->crud->setModel('App\Models\Response');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/response');
        $this->crud->setEntityNameStrings('Response', 'Response');
        $this->data['script_js'] = $this->getScripsJs();


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

            //update value in gauge
            var ageRiskFactor = $('#age_risk_factor').val();
            var covidRiskIndex = $('#covid_risk_index').val();
            var probabilityOfCovidInfection = $('#probability_of_covid_infection').val();
            gauge.set(covidRiskIndex);



            //js for autoloading lat and long from local_level
            $('#local_level_id').on('change',function(){
                var localLevelId = $('#local_level_id').val();
                    if(localLevelId != null){
                    $.ajax({
                        type: 'GET',
                        url: '/response/getlatlong',
                        data: { localLevelId: localLevelId },
                        success: function(response) {
                            console.log(response);
                            if(response.message == 'success'){
                                $('#gps_lat').val(response.locallevel.gps_lat).trigger('change');
                                $('#gps_long').val(response.locallevel.gps_long).trigger('change');
                                changeLatDecimalToDegree();
                                changeLongDecimalToDegree();
                                updateMarkerByInputs();
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
                getLocation();
            }else{
                updateMarkerByInputs();
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
                 updateMarkerByInputs();
            });

        
            $('#gps_long').on('keyup', function() {
                changeLongDecimalToDegree();
                 updateMarkerByInputs();

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
                'label' => trans('Name'),
                
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('नाम'),
                
            ],
            [
                'name' => 'province_district',
                'type' => 'model_function',
                'function_name' =>'province_district',
                'label' => trans('प्रदेश').'<br>'.trans('जिल्ला'),
            ],
            [
                'name'=>'local_address',
                'type' => 'model_function',
                'function_name' =>'local_address',
                'label'=>trans('स्थानीय तह').'<br>'.trans('वडा नं.'),
            ],
          
        ];
        $this->crud->addColumns($cols);
   

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ResponseRequest::class);

        $mode = $this->crud->getActionMethod();
        $process_step_id = NULL;
        $gauge = NULL;
        $age_risk_factor = NULL;
        $covid_risk_index = NULL;
        $probability_of_covid_infection = NULL;
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

            if($current_process_step_id == 4){

            $gauge = [
                'name' => 'gauge',
                'type' => 'gauge',

            ];

            $age_risk_factor = [
                'name' => 'age_risk_factor',
                'type' => 'hidden',
                'attributes' => [
                    'id' => 'age_risk_factor',
                ]
            ];
             $covid_risk_index = [
                'name' => 'covid_risk_index',
                'type' => 'hidden',
                'attributes' => [
                    'id' => 'covid_risk_index',
                ]
            ];

            $probability_of_covid_infection = [
                'name' => 'probability_of_covid_infection',
                'type' => 'hidden',
                'attributes' => [
                    'id' => 'probability_of_covid_infection',
                ]
            ];
        }
        }

        $arr = [
            $process_step_id,
            $gauge,
            $age_risk_factor,
            $probability_of_covid_infection,
            $covid_risk_index,
            $this->addReadOnlyCodeField(),
            [
                'name' => 'legend1',
                'type' => 'custom_html',
                'value' => '',
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('नाम'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name' => 'age',
                'type' => 'number',
                'label' => trans('उमेर'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
                'suffix' => 'बर्ष',
            ],

            [
                'name'=>'gender_id',
                'type'=>'select2',
                'label'=>trans('लिङ्ग'),
                'entity'=>'gender',
                'model'=>'App\Models\MstGender',
                'attribute'=>'name_lc',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],

            [
                'name' => 'legend2',
                'type' => 'custom_html',
                'value' => '<b><legend>Education and Profession:</legend></b>',
                'wrapperAttributes'=>[
                    'class' => 'legend0'
                ],
            ],
          
            [
                'name'=>'education_id',
                'type'=>'select2',
                'label'=>trans('शैक्षिक योग्यता'),
                'entity'=>'education',
                'model'=>'App\Models\MstEducationalLevel',
                'attribute'=>'name_lc',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name'=>'profession_id',
                'type'=>'select2',
                'label'=>trans('पेशा'),
                'entity'=>'profession',
                'model'=>'App\Models\MstProfession',
                'attribute'=>'name_en',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name' => 'email',
                'type' => 'text',
                'label' => trans('Email'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden',
                ],
            ],
  


            [
                'name' => 'legend3',
                'type' => 'custom_html',
                'value' => '<b><legend>Address</legend></b>',
                'wrapperAttributes'=>[
                    'class' => 'legend0'
                ]
            ],
            [
                'name'=>'province_id',
                'type'=>'select2',
                'label'=>trans('प्रदेश'),
                'entity'=>'province',
                'model'=>'App\Models\MstProvince',
                'attribute'=>'name_lc',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],
            [
                'name'=>'district_id',
                'label'=>trans('जिल्ला'),
                'type'=>'select2_from_ajax',
                'model'=>'App\Models\MstDistrict',
                'entity'=>'district',
                'attribute'=>'name_lc',
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
                'label'=>trans('स्थानीय तह'),
                'type'=>'select2_from_ajax',
                'entity'=>'locallevel',
                'model'=>'App\Models\MstLocalLevel',
                'attribute'=>'name_lc',
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
                'label'=>trans('वडा नं.'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden',
                ],
            ],


            [
                'name' => 'legend4',
                'type' => 'custom_html',
                'value' => '<b><legend>GPS Co-ordinates</legend></b>',
                'wrapperAttributes'=>[
                    'class' => 'legend0'
                ]
            ],
            [
                'name' => 'separater1',
                'type' => 'custom_html',
                'value' => '<h5><b><span style="position: relative; top:23px;">Latitude :</span></b></h5>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
            ],
            [
                'name' => 'gps_lat_degree',
                'fake' => true,
                'label' => trans('Degrees'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'gps_lat_degree',
                ],
            ],
            [
                'name' => 'gps_lat_minute',
                'fake' => true,
                'label' => trans('Minutes'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'gps_lat_minute',

                ],
            ],
            [
                'name' => 'gps_lat_second',
                'fake' => true,
                'label' => trans('Seconds'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'gps_lat_second',

                ],
            ],
            [
                'name' => 'arrow1',
                'type' => 'custom_html',
                'value' => '<b><span style="position: relative; top:25px; font-size:22px; color:red;">&#8651;</span></b>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-1 toBeHidden',
                ],
            ],
            [
                'name' => 'gps_lat',
                'label' => trans('Decimal Degrees Latitude'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3 toBeHidden',
                ],
                'attributes' => [
                    'step' => 'any',
                    'id' => 'gps_lat',
                ],
                'default' => '0',
            ],
            [
                'name' => 'separater2',
                'type' => 'custom_html',
                'value' => '<h5><b><span style="position: relative; top:23px;">Longitude :</span></b></h5>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
            ],
            [
                'name' => 'gps_long_degree',
                'fake' => true,
                'label' => trans('Degrees'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'gps_long_degree',
                ],
            ],
            [
                'name' => 'gps_long_minute',
                'fake' => true,
                'label' => trans('Minutes'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'gps_long_minute',
                ],
            ],
            [
                'name' => 'gps_long_second',
                'fake' => true,
                'label' => trans('Seconds'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2 toBeHidden',
                ],
                'attributes' => [
                    'id' => 'gps_long_second',
                ],
            ],
            [
                'name' => 'arrow2',
                'type' => 'custom_html',
                'value' => '<b><span style="font-size:22px; position: relative; top:25px; color:red;">&#8651;</span></b>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-1 toBeHidden',
                ],
            ],

          [
                'name' => 'gps_long',
                'label' => trans('Decimal Degrees Longitude'),
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

            [
                'name' => 'map',
                'type' => 'map',
                'wrapperAttributes' => [
                    'class' => 'toBeHidden',
                ],
            ],



            [
                'name' => 'legend5',
                'type' => 'custom_html',
                'value' => '<legend>Personal Travel</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b>Do you ?</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'personal_travel',
                'entity'    => 'personal_travel',
                'attribute' => 'name_lc',
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
                'name' => 'legend6',
                'type' => 'custom_html',
                'value' => '<legend>Safety Measure</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b>Do you ?</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'safety_measure',
                'entity'    => 'safety_measure',
                'attribute' => 'name_lc',
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
                'name' => 'legend7',
                'type' => 'custom_html',
                'value' => '<legend>Habits</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b>Do you?</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'habits',
                'entity'    => 'habits',
                'attribute' => 'name_lc',
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
                'name' => 'legend8',
                'type' => 'custom_html',
                'value' => '<legend>Existing Health Condition</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b>Do you have any of the following heath condition ?</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'health_condition',
                'entity'    => 'health_condition',
                'attribute' => 'name_lc',
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
                'name' => 'legend9',
                'type' => 'custom_html',
                'value' => '<legend>Symptom</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend1'
                ]  
            ],

            [
                'label'     => '<b>Do you have any of the following symptoms(currently) ?</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'symptom',
                'entity'    => 'symptom',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(5)->get();
                }),
                'pivot'     => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden1',
                ],
       

            [
                'name' => 'legend10',
                'type' => 'custom_html',
                'value' => '<legend>Neighbour Proximity</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]  
            ],

            [
                'label'     => '<b>Nearby houses from your home (with in 100 meters)</b>',
                'type'      => 'select2',
                'name'      => 'neighbour_proximity',
                'entity'    => 'neighbour_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(6)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend11',
                'type' => 'custom_html',
                'value' => '<legend>Community Situation</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]                
            ],

            [
                'label'     => '<b>How is current situation in your community ?</b>',
                'type'      => 'select2',
                'name'      => 'community_situation',
                'entity'    => 'community_situation',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(7)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],

            ],
          
            [
                'name' => 'legend13',
                'type' => 'custom_html',
                'value' => '<legend>Confirmed Case</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Is there any confirmed case in your community ?</b>',
                'type'      => 'select2',
                'name'      => 'confirmed_case',
                'entity'    => 'confirmed_case',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(9)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],

            [
                'name' => 'legend14',
                'type' => 'custom_html',
                'value' => '<legend>Inbound Foreign Travel</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Are there any people travelled recently from abroad ?</b>',
                'type'      => 'select2',
                'name'      => 'inbound_foreign_travel',
                'entity'    => 'inbound_foreign_travel',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(10)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]            ],


            [
                'name' => 'legend15',
                'type' => 'custom_html',
                'value' => '<legend>Community Population</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Population of your community(village/tole, where you mostly interact in normal time)</b>',
                'type'      => 'select2',
                'name'      => 'community_population',
                'entity'    => 'community_population',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(11)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]            ],


            [
                'name' => 'legend16',
                'type' => 'custom_html',
                'value' => '<legend>Hospital Proximity</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>How far is the hospital/healthpost ?</b>',
                'type'      => 'select2',
                'name'      => 'hospital_proximity',
                'entity'    => 'hospital_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(12)->get();
                }),
               'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend17',
                'type' => 'custom_html',
                'value' => '<legend>Corona Centre Proximity</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>How far is the corona centre ?</b>',
                'type'      => 'select2',
                'name'      => 'corona_centre_proximity',
                'entity'    => 'corona_centre_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(13)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend18',
                'type' => 'custom_html',
                'value' => '<legend>Health Facility</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Condition of hospital/healthpost</b>',
                'type'      => 'select2',
                'name'      => 'health_facility',
                'entity'    => 'health_facility',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(14)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend19',
                'type' => 'custom_html',
                'value' => '<legend>Market Proximity</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>How far is the market area from your place or locality ?</b>',
                'type'      => 'select2',
                'name'      => 'market_proximity',
                'entity'    => 'market_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(15)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend20',
                'type' => 'custom_html',
                'value' => '<legend>Food Stock</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Were there sufficient food items supplies in your house during lock down ?</b>',
                'type'      => 'select2',
                'name'      => 'food_stock',
                'entity'    => 'food_stock',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(16)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend21',
                'type' => 'custom_html',
                'value' => '<legend>Agri Producer Seller</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Are you able to sell your agricultutal products in market ?</b>',
                'type'      => 'select2',
                'name'      => 'agri_producer_seller',
                'entity'    => 'agri_producer_seller',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(17)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend22',
                'type' => 'custom_html',
                'value' => '<legend>Product Selling Price</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Are you getting regular price compared to normal situation ?</b>',
                'type'      => 'select2',
                'name'      => 'product_selling_price',
                'entity'    => 'product_selling_price',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(18)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend23',
                'type' => 'custom_html',
                'value' => '<legend>Commodity Availability</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Is there food and other commoditiity item available in local market ?</b>',
                'type'      => 'select2',
                'name'      => 'commodity_availability',
                'entity'    => 'commodity_availability',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(19)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend24',
                'type' => 'custom_html',
                'value' => '<legend>Commodity Price Difference</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>What is the state of market food and commodity price ?</b>',
                'type'      => 'select2',
                'name'      => 'commodity_price_difference',
                'entity'    => 'commodity_price_difference',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(20)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],
              [
                'name' => 'legend12',
                'type' => 'custom_html',
                'value' => '<legend>Economic Impact</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]  
            ],

            [
                'label'     => '<b>Economic impact of pandemic in your life</b>',
                'type'      => 'select2',
                'name'      => 'economic_impact',
                'entity'    => 'economic_impact',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(8)->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend25',
                'type' => 'custom_html',
                'value' => '<legend>Job Status</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>Are you regularly doing your job ?</b>',
                'type'      => 'select2',
                'name'      => 'job_status',
                'entity'    => 'job_status',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(21)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend26',
                'type' => 'custom_html',
                'value' => '<legend>Sustainability Duration</legend>',
                'wrapperAttributes'=>[
                    'class' => 'legend2'
                ]
            ],

            [
                'label'     => '<b>How long can you sustain in the current situaiton ?</b>',
                'type'      => 'select2',
                'name'      => 'sustainability_duration',
                'entity'    => 'sustainability_duration',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(22)->get();
                }),
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-6 toBeHidden2'
                ]
            ],


            [
                'name' => 'legend27',
                'type' => 'custom_html',
                'value' => '',
            ],
            [
                'name' => 'remarks',
                'label' => trans('common.remarks'),
                'type' => 'textarea',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12 toBeHidden'
                ]
            ]


        ];
        $arr = array_filter($arr);
        $this->crud->addFields($arr);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function nextstep($id){
     
    $request = $this->crud->validateRequest();
    ResponseProcessHelper::updateProcess($id, $request,'next');

    $response = Response::whereId($id)->get()->toArray();
    $process_step_id = $response[0]['process_step_id'];

        if($process_step_id == 4){
            $risk_calculation = new RiskCalculationHelper();
            $risk_calculation->calculate_risk($id);
        }

        if(backpack_user()){
            return redirect(backpack_url('/response').'/'.$id.'/edit');
        }else{
            return redirect(url('/fill_response').'/'.$id.'/edit');
        }
    }

    public function backstep($id){
     
    ResponseProcessHelper::updateProcess($id,$request=NULL,'back');

    if(backpack_user()){
        return redirect(backpack_url('/response').'/'.$id.'/edit');
    }else{
        return redirect(url('/fill_response').'/'.$id.'/edit');
    }
    }

    
    public function store()
    {
        // $this->crud->hasAccessOrFail('create');
         $request = $this->crud->validateRequest();
        // execute the FormRequest authorization and validation, if one is required
         if ($request->has('code')) {
            $query = $this->crud->model->latest('code')->first();
            $code = 1;
            if ($query != null) {
                $code = $query->code + 1;
            }
            // TODO : $request->request->set('code', $code);
            request()->request->set('code', $code);
        }

        if(!backpack_user()){
            $itemId = $this->saveRequest($request);
            \Alert::success(trans('Data Submitted Successfully'))->flash();
            return redirect(url('/fill_response').'/'.$itemId.'/edit');
        }else{

           // insert item in the db
            DB::beginTransaction();
            try {
                $item = $this->crud->create($this->crud->getStrippedSaveRequest());
                $this->data['entry'] = $this->crud->entry = $item;

                $itemId = $item->id;
        
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
                // show a success message
            \Alert::success(trans('Data Submitted Successfully'))->flash();
            return redirect(backpack_url('/response').'/'.$itemId.'/edit');
        }
    }

    public function saveRequest($request){
        $dataSet= [
        'code' => $request->code,
        'name_en' => $request->name_en,
        'name_lc' => $request->name_lc,
        'age' => $request->age,
        'gender_id' => $request->gender_id,
        'education_id' => $request->education_id,
        'profession_id' => $request->profession_id,
        'email' => $request->email,
        'province_id' => $request->province_id,
        'district_id' => $request->district_id,
        'local_level_id' => $request->local_level_id,
        'ward_number' => $request->ward_number,
        'gps_lat' => $request->gps_lat,
        'gps_long' => $request->gps_long,
        'remarks' => $request->remarks,
        ];

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

    public function fetchLatLong(Request $request){
        $localLevelId = $request->localLevelId;
        
        $locallevel = MstLocalLevel::find($localLevelId);
         if($locallevel){
            return response()->json([
                'message' => 'success',
                'locallevel' => $locallevel
            ]);
        }else{
            return response()->json([
                'message' => 'fail',
            ]);
        }
    }
}
