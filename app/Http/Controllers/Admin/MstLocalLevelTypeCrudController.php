<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstLocalLevelTypeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LocalLevelTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstLocalLevelTypeCrudController extends BaseCrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\MstLocalLevelType');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/localleveltype');
        $this->crud->setEntityNameStrings('स्थानीय तह प्रकार', 'स्थानीय तह प्रकार');
    }

    protected function setupListOperation()
    {
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('localleveltype.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('localleveltype.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
         
    
            ];
            $this->crud->addColumns($col);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstLocalLevelTypeRequest::class);

        $arr=[
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
                'label' => trans('localleveltype.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('localleveltype.name_lc'),
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
