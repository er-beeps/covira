<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstEducationalLevelRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstEducationalLevelCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstEducationalLevelCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\MstEducationalLevel');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/educationallevel');
        $this->crud->setEntityNameStrings('शैक्षिक योग्यता', 'शैक्षिक योग्यता');
    }

    protected function setupListOperation()
    {
        $col = [
            $this->addRowNumber(),
            $this->addCodeColumn(),
             [
                 'name' => 'name_lc',
                 'type' => 'text',
                 'label' => trans('educationallevel.name_lc'),
             ],
             [
                 'name' => 'name_en',
                 'type' => 'text',
                 'label' => trans('educationallevel.name_en'),
             ],
          
     
             ];
             $this->crud->addColumns($col);  
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstEducationalLevelRequest::class);

        
        $arr = [
            $this->addReadOnlyCodeField(),
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('educationallevel.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('educationallevel.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            
            [
                'name' => 'display_order',
                'type' => 'number',
                'label' => trans('educationallevel.display_order'),
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
