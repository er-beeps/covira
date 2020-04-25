<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\PrActivityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PrActivityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PrActivityCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\PrActivity');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/practivity');
        $this->crud->setEntityNameStrings('क्रियाकलाप', 'क्रियाकलाप');
    }

    protected function setupListOperation()
    {
       $cols =
       [
            $this->addRowNumber(),
            $this->addCodeColumn(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('Name'),
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('नाम'),
            ],
            [  
                'label' => trans('Factor'),
                'type' => 'select',
                'name' => 'factor_id',
                'entity' => 'factor', 
                'attribute' => 'name_lc', 
                'model' => "App\Models\PrFactor",
            ],
            [
                'name' => 'scale_high',
                'label' => trans('Scale (High)'),
                'type' => 'number',
            ],
            [
                'name' => 'scale_low',
                'label' => trans('Scale (Low)'),
                'type' => 'number',
            ],
            [
                'name' => 'weight_factor',
                'label' => trans('Weight Factor'),
                'type' => 'number',
            ],

        ];
        $this->crud->addColumns($cols);
    
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PrActivityRequest::class);
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
                'label' => trans('Activity Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('क्रियाकलापको नाम'),
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
                'name' => 'legend2',
                'type' => 'custom_html',
                'value' => '<b><legend></legend></b>',
            ],
            [  // Select
                'label' => trans('Factor'),
                'type' => 'select2',
                'name' => 'factor_id', // the db column for the foreign key
                'entity' => 'factor', // the method that defines the relationship in your Model
                'attribute' => 'name_lc', // foreign key attribute that is shown to user
                'model' => "App\Models\PrFactor",
                // optional
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                // optional
                'options'   => (function ($query) {
                    return (new \App\Models\PrFactor())->getFieldComboOptions($query);
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name' => 'weight_factor',
                'label' => trans('Weight Factor'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'scale_high',
                'label' => trans('Scale (High)'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'scale_low',
                'label' => trans('Scale (Low)'),
                'type' => 'number',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
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
