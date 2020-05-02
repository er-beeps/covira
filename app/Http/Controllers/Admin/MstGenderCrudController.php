<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstGenderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class GenderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstGenderCrudController extends BaseCrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\MstGender');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/gender');
        $this->crud->setEntityNameStrings('लिङ्ग','लिङ्ग');
    }

    protected function setupListOperation()
    {
       
        $col = [
           $this->addRowNumber(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('gender.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('gender.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
         
    
            ];
            $this->crud->addColumns($col);
            $this->crud->orderBy('id');

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstGenderRequest::class);

        $arr = [
            // $this->addCodeField(),
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('gender.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('gender.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            $this->addRemarksField(),
            //display_order
        ];
        $this->crud->addFields($arr);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
