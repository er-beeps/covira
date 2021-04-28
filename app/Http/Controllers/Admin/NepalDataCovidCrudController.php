<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\NepalDataCovidRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NepalDataCovidCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NepalDataCovidCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\NepalDataCovid');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/nepaldatacovid');
        $this->crud->setEntityNameStrings('', 'Nepal Covid Data');

        $this->crud->addButtonFromModelFunction('top', 'Fetch', 'fetchData', 'end');

    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $column=[
            $this->addRowNumber(),
        ];
        $this->crud->addColumns($column);
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(NepalDataCovidRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
