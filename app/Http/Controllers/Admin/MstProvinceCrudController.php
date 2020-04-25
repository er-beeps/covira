<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstProvinceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProvinceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstProvinceCrudController extends BaseCrudController
{
   
    public function setup()
    {
        $this->crud->setModel('App\Models\MstProvince');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/province');
        $this->crud->setEntityNameStrings('प्रदेश', 'प्रदेश');
    }

    protected function setupListOperation()
    {
   
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('province.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('province.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
        ];
        $this->crud->addColumns($col);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstProvinceRequest::class);

        $arr = [
                $this->addReadOnlyCodeField(),    
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('province.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('province.name_lc'),
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
