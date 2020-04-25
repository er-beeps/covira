<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrActivity;
use App\Base\Traits\ParentData;
use App\Base\BaseCrudController;
use App\Http\Requests\ResponseRequest;
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
                'label' => trans('प्रदेश').'<br>'.trans('जिल्ला'),
            ],
            [
                'name'=>'local_address',
                'label'=>trans('स्थानीय तह').'<br>'.trans('वडा नं.'),
            ],
          
        ];
        $this->crud->addColumns($cols);
   

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ResponseRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],

            [
                'name' => 'legend1',
                'type' => 'custom_html',
                'value' => '<b><legend></legend></b>',
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('नाम'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],

            [
                'name'=>'gender_id',
                'type'=>'select2',
                'label'=>trans('लिङ्ग'),
                'entity'=>'gender',
                'model'=>'App\Models\MstGender',
                'attribute'=>'name_lc',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],

            [
                'name' => 'legend2',
                'type' => 'custom_html',
                'value' => '<b><legend>Education and Profession</legend></b>',
            ],
          
            [
                'name'=>'education_id',
                'type'=>'select2',
                'label'=>trans('शैक्षिक योग्यता'),
                'entity'=>'education',
                'model'=>'App\Models\MstEducationalLevel',
                'attribute'=>'name_lc',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
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
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'email',
                'type' => 'text',
                'label' => trans('Email'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-12',
                ],
            ],
  
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],

            [
                'name' => 'legend3',
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
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],

            [
                'name' => 'legend4',
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

            // [
            //     'name' => 'map',
            //     'type' => 'map',
            // ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],

            [
                'name' => 'legend5',
                'type' => 'custom_html',
                'value' => '<legend><b>Activities</b></legend>',
            ],

            [
                'label'     => '<b>Personal Travel</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'personal_travel',
                'entity'    => 'personal_travel',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(1)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend6',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Safety Measure</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'safety_measure',
                'entity'    => 'safety_measure',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(2)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend7',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Habits</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'habits',
                'entity'    => 'habits',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(3)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend8',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Health Condition</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'health_condition',
                'entity'    => 'health_condition',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(4)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend9',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Symptom</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'symptom',
                'entity'    => 'symptom',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(5)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend10',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Neighbour Proximity</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'neighbour_proximity',
                'entity'    => 'neighbour_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(6)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend11',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Community Situation</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'community_situation',
                'entity'    => 'community_situation',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(7)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend12',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Economic Impact</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'economic_impact',
                'entity'    => 'economic_impact',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(8)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend13',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Confirmed Case</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'confirmed case',
                'entity'    => 'confirmed case',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(9)->get();
                }),
                'pivot'     => true,
            ],


            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend14',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Inbound Foreign Travel</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'inbound_foreign_travel',
                'entity'    => 'inbound_foreign_travel',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(10)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend15',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Community Population</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'community_population',
                'entity'    => 'community_population',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(11)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend16',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Hospital Proximity</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'hospital_proximity',
                'entity'    => 'hospital_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(12)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend17',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Corona Centre Proximity</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'corona_centre_proximity',
                'entity'    => 'corona_centre_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(13)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend18',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Health Facility</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'health_facility',
                'entity'    => 'health_facility',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(14)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend19',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Market Proximity</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'market_proximity',
                'entity'    => 'market_proximity',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(15)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend20',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Food Stock</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'food_stock',
                'entity'    => 'food_stock',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(16)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend21',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Agri Producer Seller</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'agri_producer_seller',
                'entity'    => 'agri_producer_seller',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(17)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend22',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Product Selling Price</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'product_selling_price',
                'entity'    => 'product_selling_price',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(18)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend23',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Commodity Availability</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'commodity_availability',
                'entity'    => 'commodity_availability',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(19)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend24',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Commodity Price Difference</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'commodity_price_difference',
                'entity'    => 'commodity_price_difference',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(20)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend25',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Job Status</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'job_status',
                'entity'    => 'job_status',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(21)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend26',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
            ],

            [
                'label'     => '<b>Sustainability Duration</b>',
                'type'      => 'checklist_filtered',
                'name'      => 'sustainability_duration',
                'entity'    => 'sustainability_duration',
                'attribute' => 'name_lc',
                'model'     => PrActivity::class,
                'options'   => (function ($query) {
                    return $query->whereFactorId(22)->get();
                }),
                'pivot'     => true,
            ],

            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [
                'name' => 'legend27',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
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
