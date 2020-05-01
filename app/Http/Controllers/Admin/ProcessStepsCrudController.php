<?php

namespace App\Http\Controllers\Admin;

use App\Base\BaseCrudController;
use App\Http\Requests\ProcessStepsRequest;


/**
 * Class ProcessStepsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProcessStepsCrudController extends BaseCrudController
{
  

    public function setup()
    {
        $this->crud->setModel('App\Models\ProcessSteps');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/processsteps');
        $this->crud->setEntityNameStrings('processsteps', 'process_steps');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ProcessStepsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
