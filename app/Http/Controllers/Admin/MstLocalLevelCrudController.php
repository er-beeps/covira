<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\MstLocalLevelRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LocalLevelCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MstLocalLevelCrudController extends BaseCrudController
{

    public function setup()
    {
        $this->crud->setModel('App\Models\MstLocalLevel');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/locallevel');
        $this->crud->setEntityNameStrings('स्थानीय तह','स्थानीय तह');
    }
    protected function setFilters(){
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'code',
            'label'=> 'Code'
          ], 
          false, 
          function($value) { // if the filter is active
            $value = trim($value);
            $this->crud->addClause('where', 'code', 'ILIKE', "%$value%");
        });
        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'name_en',
            'label'=> 'Name'
          ], 
          false, 
          function($value) { // if the filter is active
            $value = trim($value);
            $this->crud->addClause('where', 'name_en', 'ILIKE', "%$value%");
        });
        // select2 filter
        $this->crud->addFilter([
            'name'  => 'district_id',
            'type'  => 'select2',
            'label' => 'District'
        ], function () {
            return (new \App\Models\MstDistrict())->orderBy('name_lc', 'ASC')->get()->keyBy('id')->pluck('name_lc', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'district_id', $value);
        });

        $this->crud->addFilter([
            'name'  => 'level_type_id',
            'type'  => 'select2',
            'label' => 'Type'
        ], function () {
            return (new \App\Models\MstLocalLevelType())->orderBy('name_lc', 'ASC')->get()->keyBy('id')->pluck('name_lc', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'level_type_id', $value);
        });
    }
    protected function setupListOperation()
    {
        $this->setFilters();
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
           
           [
            // 1-n relationship
                'label' => "District", // Table column heading
                'type' => "select",
                'name' => 'district_id', // the column that contains the ID of that connected entity;
                'entity' => 'district', // the method that defines the relationship in your Model
                'attribute' => "name_lc", // foreign key attribute that is shown to user
                'model' => "App\Models\MstDistrict", // foreign key model,
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('district', function ($q) use ($column, $searchTerm) {
                        $q->where('name_lc', 'ilike', '%'.$searchTerm.'%');
                        $q->orWhere('name_en', 'ilike', '%'.$searchTerm.'%');
                    });
                }
            ],
            [
            // 1-n relationship
                'label' => "स्थानीय तह प्रकार", // Table column heading
                'type' => "select",
                'name' => 'level_type_id', // the column that contains the ID of that connected entity;
                'entity' => 'localleveltype', // the method that defines the relationship in your Model
                'attribute' => "name_lc", // foreign key attribute that is shown to user
                'model' => "App\Models\MstLocalLevelType", // foreign key model
            ],
        
            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('locallevel.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('locallevel.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

    
            ];
            $this->crud->addColumns($col);
    }


    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MstLocalLevelRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        // $this->crud->setFromDb();

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
            [  // Select2
                'label' => "District",
                'type' => 'select2',
                'name' => 'district_id', // the db column for the foreign key
                'entity' => 'district', // the method that defines the relationship in your Model
                'attribute' => 'name_lc', // foreign key attribute that is shown to user
                // optional
                'model' => "App\Models\MstDistrict", // foreign key model
                // 'default' => 2, // set the default value of the select2
                'options'   => (function ($query) {
                     return $query->orderBy('code', 'ASC')->get();
                 }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-5',
                ],
            ],
            [  // Select2
                'label' => "स्थानीय तह प्रकार",
                'type' => 'select2',
                'name' => 'level_type_id', // the db column for the foreign key
                'entity' => 'localleveltype', // the method that defines the relationship in your Model
                'attribute' => 'name_lc', // foreign key attribute that is shown to user
                // optional
                'model' => "App\Models\MstLocalLevelType", // foreign key model
                // 'default' => 2, // set the default value of the select2
                'options'   => (function ($query) {
                     return $query->orderBy('code', 'ASC')->get();
                 }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
                 'wrapperAttributes' => [
                    'class' => 'form-group col-md-5',
                ],
            ],
        
            [
                'name' => 'name_en',
                'type' => 'text',
                'label' => trans('localLevel.name_en'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'name_lc',
                'type' => 'text',
                'label' => trans('localLevel.name_lc'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],

            [
                'name' => 'gps_lat',
                'type' => 'text',
                'label' => 'GPS (Lat)',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3',
                ],
            ],

            [
                'name' => 'gps_long',
                'type' => 'text',
                'label' => 'GPS (Long)',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-3',
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
