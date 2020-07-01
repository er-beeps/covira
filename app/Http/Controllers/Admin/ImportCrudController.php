<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Base\BaseCrudController;
use App\Imports\ImportController;
use App\Http\Requests\ImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ImportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImportCrudController extends BaseCrudController
{
    public function index()
    {
     
        return view('import_form');
    }

    public function import(Request $request){
        if( $request->file) {
            $path = $request->file->getRealPath();
            // dd($file);
        } else {
            return back()->withErrors("No file selected");
        }

        $data = Excel::import(new ImportController, $path);
    }

}
