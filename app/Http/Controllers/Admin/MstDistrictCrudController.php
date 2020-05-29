<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstDistrictRequest;
use App\Base\Traits\CheckPermission;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DistrictCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstDistrictCrudController extends BaseCrudController
{
    use checkPermission;

    public function setup()
    {
        $this->crud->setModel('App\Models\MstDistrict');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/district');
        $this->crud->setEntityNameStrings('जिल्ला', 'जिल्ला');
        $this->checkPermission();

        // $this->enableDialog(true);
    }

    

    protected function setupListOperation()
    {
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('district.name_lc'),
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('district.name_en'),
            ],
         
    
            ];
            $this->crud->addColumns($col);

            $this->addFilters();
            $this->crud->orderBy('id');

    }

    private function addFilters()
    {
        $this->crud->addFilter(
            [ // Name(en) filter
                'label' => trans('प्रदेश'),
                'type' => 'select2',
                'name' => 'province_id', // the db column for the foreign key
            ],
            function () {
                return (new \App\Models\MstProvince())->getFilterComboOptions();
            },
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'province_id', $value);
            }
        );
        // $this->addCodeFilter();
        $this->crud->addFilter(
            [ // simple filter
                'type' => 'text',
                'name' => 'name_en',
                'label' => trans('District Name')
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'name_en', 'ilike', "%$value%");
            }
        );
        $this->crud->addFilter(
            [ // simple filter
                'type' => 'text',
                'name' => 'name_lc',
                'label' => trans('जिल्लाको नाम'),
            ],
            false,
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'name_lc', 'ilike', "%$value%");
            }
        );
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstDistrictRequest::class);

        $arr=[
            $this->addCodeField(),
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
            [  // Select
                'label' => trans('coremst.province'),
                'type' => 'select2',
                'name' => 'province_id', // the db column for the foreign key
                'entity' => 'province', // the method that defines the relationship in your Model
                'attribute' => 'name_lc', // foreign key attribute that is shown to user
                'model' => "App\Models\MstProvince",
                // optional
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                // optional
                'options'   => (function ($query) {
                    return (new \App\Models\MstProvince())->getFieldComboOptions($query);
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [  
                'label' => trans('province.province_id'),
                'type' => 'select2',
                'name' => 'province_id', 
                'entity' => 'province', 
                'attribute' => 'code', 
                'model' => "App\Models\MstProvince",
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3'
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('district.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('district.name_lc'),
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
