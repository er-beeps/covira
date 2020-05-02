<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstNepaliMonthRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NepaliMonthCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstNepaliMonthCrudController extends BaseCrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\MstNepaliMonth');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/nepalimonth');
        $this->crud->setEntityNameStrings('महिना', 'महिना');
        $this->crud->denyAccess([ 'create', 'delete']);
    }

    protected function setupListOperation()
    {
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('nepalimonth.name_lc'),
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('nepalimonth.name_en'),
            ],
         
    
            ];
            $this->crud->addColumns($col);
            $this->crud->orderBy('id');

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstNepaliMonthRequest::class);

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
                'label' => trans('nepalimonth.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('nepalimonth.name_lc'),
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
