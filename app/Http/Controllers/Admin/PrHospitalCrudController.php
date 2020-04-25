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
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],

            [
                'name' => 'legend3',
                'type' => 'custom_html',
                'value' => '<b><legend>GPS Co-ordinates</legend></b>',
            ],
            [
                'name' => 'separater1',
                'type' => 'custom_html',
                'value' => '<h4><b><span style="position: relative; top:23px;">Latitude :</span></b></h4>',
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
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3',
                ],
                'attributes' => [
                    'id' => 'gps_lat',
                ],
                'default' => '0',
            ],
            [
                'name' => 'separater2',
                'type' => 'custom_html',
                'value' => '<h4><b><span style="position: relative; top:23px;">Longitude :</span></b></h4>',
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
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3',
                ],
                'attributes' => [
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
                'name' => 'legend4',
                'type' => 'custom_html',
                'value' => '<legend></legend>',
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
