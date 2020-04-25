<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\PrFactorRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PrFactorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PrFactorCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\PrFactor');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/prfactor');
        $this->crud->setEntityNameStrings('Factor', 'Factor');
    }

    protected function setupListOperation()
    {
        $col = [
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
        
             ];
             $this->crud->addColumns($col);  
       
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(PrFactorRequest::class);

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
                'label' => trans('Factor Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('Factor नाम'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'display_order',
                'type' => 'number',
                'label' => trans('profession.display_order'),
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
