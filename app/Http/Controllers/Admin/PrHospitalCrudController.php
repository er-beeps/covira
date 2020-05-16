<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\PrHospitalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PrHospitalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PrHospitalCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\PrHospital');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/prhospital');
        $this->crud->setEntityNameStrings('अस्पताल', 'अस्पताल');
        $this->data['script_js'] =  "
        $(document).ready(function() {

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

        })";
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
            [
                'name'        => 'is_covid_center',
                'label'       => trans('Covid Center हो ?'),
                'type'        => 'radio',
                'default' => 0,
                'options'     => [
                    1 => 'हो',
                    0 => 'होइन'

                ],
                
            ],
            [
                'name' => 'num_ventilator',
                'label' => trans('Ventilator संख्या'),
                'type' => 'number',
                
            ],
            [
                'name' => 'num_icu',
                'label' => trans('ICU संख्या'),
                'type' => 'number',
                
            ],
        ];
        $this->crud->addColumns($cols);   
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PrHospitalRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),

            [
                'name' => 'legend1',
                'type' => 'custom_html',
                'value' => '',
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('Hospital Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('अस्पतालको नाम'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
  
            [
                'name' => 'legend2',
                'type' => 'custom_html',
                'value' => '<b><legend>Address</legend></b>',
            ],
            [
                'name'=>'province_id',
                'type'=>'select2',
                'label'=>trans('प्रदेश'),
                'entity'=>'province',
                'model'=>'App\Models\MstProvince',
                'attribute'=>'name_lc',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
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
                    'class' => 'form-group col-md-6',
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
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name'=>'ward_number',
                'type'=>'number',
                'label'=>trans('वडा नं.'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'legend3',
                'type' => 'custom_html',
                'value' => '<b><legend>GPS Co-ordinates</legend></b>',
            ],
            [
                'name' => 'separater1',
                'type' => 'custom_html',
                'value' => '<h5><b><span style="position: relative; top:23px;">Latitude :</span></b></h5>',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2',
                ],
            ],
            [
                'name' => 'gps_lat_degree',
                'fake' => true,
                'label' => trans('Degrees'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2',
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
                    'class' => 'form-group col-md-2',
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
                    'class' => 'form-group col-md-2',
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
                    'class' => 'form-group col-md-1',
                ],
            ],
            [
                'name' => 'gps_lat',
                'label' => trans('Decimal Degrees Latitude'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3',
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
                    'class' => 'form-group col-md-2',
                ],
            ],
            [
                'name' => 'gps_long_degree',
                'fake' => true,
                'label' => trans('Degrees'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2',
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
                    'class' => 'form-group col-md-2',
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
                    'class' => 'form-group col-md-2',
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
                'class' => 'form-group col-md-1',
            ],
        ],

          [
                'name' => 'gps_long',
                'label' => trans('Decimal Degrees Longitude'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3',
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
            ],

            [
                'name' => 'legend4',
                'type' => 'custom_html',
                'value' => '',
            ],
            [
                'name'        => 'is_covid_center',
                'label'       => trans('Covid Center हो ?'),
                'type'        => 'radio',
                'default' => 0,
                'options'     => [
                    1 => 'हो',
                    0 => 'होइन'

                ],
                'inline' => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'num_ventilator',
                'label' => trans('Ventilator संख्या'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'num_icu',
                'label' => trans('ICU संख्या'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            
            [
                'name' => 'display_order',
                'type' => 'number',
                'label' => trans('Display Order'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            $this->addRemarksField(),
        ];
        $this->crud->addFields($arr);


    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
