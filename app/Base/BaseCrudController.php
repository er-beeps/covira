<?php

namespace App\Base;


use App\Base\Crud\CrudPanel;
use Illuminate\Support\Facades\Route;
use App\Base\Operations\ListOperation;
use App\Base\Operations\ShowOperation;
use App\Base\Operations\CreateOperation;
use App\Base\Operations\DeleteOperation;
use App\Base\Operations\UpdateOperation;
use App\Base\Traits\ParentData;
use Backpack\CRUD\app\Http\Controllers\CrudController;


class BaseCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use ParentData;

    public function __construct()
    {

        if ($this->crud) {
            $this->enableDialog(false);
            return;
        }

        $this->middleware(function ($request, $next) {
            $this->crud = app()->make(CrudPanel::class);
            $this->enableDialog(false);
            // ensure crud has the latest request
            $this->crud->setRequest($request);
            $this->request = $request;
            $this->setupDefaults();
            $this->setup();
            $this->crud->denyAccess('show');
            $this->setupConfigurationForCurrentOperation();
            return $next($request);
        });
        // parent::__construct();
    }

    protected function addCodeField()
    {
        return [
            'name' => 'code',
            'label' => trans('common.code'),
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            // 'attributes' => [
            //     'readonly' => true,
            // ],
        ];
    }

    protected function addReadOnlyCodeField()
    {
        return [
            'name' => 'code',
            'label' => trans('common.code'),
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
            'attributes' => [
                'readonly' => true,
            ],
        ];
    }

    // ROW NUMBERS
    protected function addRowNumber()
    {
        return [
            'name' => 'row_number',
            'type' => 'row_number',
            'label' => trans('common.sn'),
        ];
    }

    protected function addCodeColumn()
    {
        return [
            'name' => 'code', // The db column name
            'label' => trans('common.code'), // Table column heading
        ];
    }

    protected function addRemarksField()
    {
        return [
            'name' => 'remarks',
            'label' => trans('common.remarks'),
            'type' => 'textarea',
        ];
    }
}
