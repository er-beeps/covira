<?php

namespace App\Base\Operations;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request as StoreRequest;

trait CreateOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCreateRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/create', [
            'as'        => $routeName.'.create',
            'uses'      => $controller.'@create',
            'operation' => 'create',
        ]);

        Route::post($segment, [
            'as'        => $routeName.'.store',
            'uses'      => $controller.'@store',
            'operation' => 'create',
        ]);

        Route::get($segment.'/create_ajax', [
            'as'        => $routeName.'.create_ajax',
            'uses'      => $controller.'@create_ajax',
            'operation' => 'create_ajax',
        ]);

        // Route::post($segment.'/create/dialog', [
        //     'as'        => $routeName.'.store_dialog',
        //     'uses'      => $controller.'@store_dialog',
        //     'operation' => 'create_dialog',
        // ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCreateDefaults()
    {
        $this->crud->allowAccess('create');

        $this->crud->operation('create', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('top', 'create', 'view', 'crud::buttons.create');
        });
    }
    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create_ajax()
    {
        $this->enableDialog(true);
        // $this->crud->removeAllFields();
        $this->setupUpdateOperation();
        // $this->crud->setEditView('admin.scheme.edit_ajax');
        return $this->create();
    }
    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        
        // $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        
        $enableDialog =  property_exists($this, 'enableDialog') ? $this->enableDialog : false;
        if ($enableDialog) {
            return view($this->crud->getCreateView(), $this->data)->renderSections()['content'];
        } else {
            return view($this->crud->getCreateView(), $this->data);
        }


        return view($this->crud->getCreateView(), $this->data);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // $this->crud->hasAccessOrFail('create');
        $this->crud->setOperation('create');

        $request = $this->crud->validateRequest();

        // $user_id = backpack_user()->id;
        // $request->request->set('created_by', $user_id);

        if($request->has('code')){
            if(trim($request->get('code')) == ''){
                $qu = DB::table($this->crud->model->getTable())
                    ->selectRaw('COALESCE(max(code::NUMERIC),0)+1 as code')
                    ->whereRaw("(code ~ '^([0-9]+[.]?[0-9]*|[.][0-9]+)$') = true");
            
                $rec = $qu->first();
                if(isset($rec)){
                    $code = $rec->code;
                }
                else{
                    $code = 1;
                }
                $request->request->set('code', $code);
                // $item['code'] = $code;
            }
        }

        // execute the FormRequest authorization and validation, if one is required

        // insert item in the db
//        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $item = $this->crud->create($request->except(['save_action', 'http_referrer', '_token']));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
