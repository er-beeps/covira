<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstProfessionRequest;
use App\Base\Traits\CheckPermission;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MstProfessionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MstProfessionCrudController extends BaseCrudController
{
    use checkPermission;
    public function setup()
    {
        $this->crud->setModel('App\Models\MstProfession');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/profession');
        $this->crud->setEntityNameStrings('Profession', 'Profession');
        $this->checkPermission();
    }

    protected function setupListOperation()
    {
        $col = [
            $this->addRowNumber(),
            $this->addCodeColumn(),
             [
                 'name' => 'name_lc',
                 'type' => 'text',
                 'label' => trans('profession.name_lc'),
             ],
             [
                 'name' => 'name_en',
                 'type' => 'text',
                 'label' => trans('profession.name_en'),
             ],
        
             ];
             $this->crud->addColumns($col);
             $this->crud->orderBy('id');  
   
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstProfessionRequest::class);

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
                'label' => trans('profession.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('profession.name_lc'),
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
