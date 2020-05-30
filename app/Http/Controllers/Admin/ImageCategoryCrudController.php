<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageCategoryRequest;
use App\Base\BaseCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ImageCategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImageCategoryCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\ImageCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/imagecategory');
        $this->crud->setEntityNameStrings('Image Category', 'Image Category');
    }

    protected function setupListOperation()
    {
   
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('नाम '),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-5',
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('Name'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-5',
                ],
            ],
        ];
        $this->crud->addColumns($col);
        $this->crud->orderBy('id');
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ImageCategoryRequest::class);

        $arr = [
                $this->addReadOnlyCodeField(), 
                [ // CustomHTML
                    'name' => 'fieldset_open',
                    'type' => 'custom_html',
                    'value' => '<fieldset>',
                ],  
                [
                    'name' => 'name_en',
                    'type' => 'text',
                    'label' => trans('Name'),
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],

                [
                    'name' => 'name_lc',
                    'type' => 'text',
                    'label' => trans('नाम '),
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-6',
                    ],
                ],
        ];
        $this->crud->addFields($arr);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
