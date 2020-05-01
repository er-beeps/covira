<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\StepMasterRequest;

/**
 * Class StepMasterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StepMasterCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\StepMaster');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/stepmaster');
        $this->crud->setEntityNameStrings('stepmaster', 'step_masters');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(StepMasterRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
