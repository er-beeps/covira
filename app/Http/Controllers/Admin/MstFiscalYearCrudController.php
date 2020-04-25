<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstFiscalYearRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FiscalYearCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstFiscalYearCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\MstFiscalYear');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/fiscalyear');
        $this->crud->setEntityNameStrings('आर्थिक वर्ष', 'आर्थिक वर्ष');
    }

    protected function setupListOperation()
    {
        
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
           [
            'name'=>'started_date',
            'label'=>trans('fiscalyear.from'),
          
        ],
        [
            'name'=>'closed_date',
            'label'=>trans('fiscalyear.to'),

        ],
         
            ];
            $this->crud->addColumns($col);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstFiscalYearRequest::class);

        $arr = [
            $this->addReadOnlyCodeField(),
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
                'name' => 'from_date_bs',
                'type' => 'text',
                'label' => 'From Date(B.S)',
                'attributes'=>
                [
                    'id'=>'from_date_bs',
                    'maxlength' =>'10',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'from_date_ad',
                'type' => 'date',
                'label' => 'From Date(A.D)',
                'attributes'=>[
                    'id'=>'from_date_ad',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'to_date_bs',
                'type' => 'text',
                'label' => 'To Date(B.S)',
                'attributes'=>
                [
                    'id'=>'to_date_bs',
                    'maxlength' =>'10',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'to_date_ad',
                'type' => 'date',
                'label' => 'To Date(A.D)',
                'attributes'=>[
                   'id'=>'to_date_ad',
                ],
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
