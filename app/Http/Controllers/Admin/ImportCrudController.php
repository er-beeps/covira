<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Base\BaseCrudController;
use App\Imports\ImportController;
use App\Http\Requests\ImportRequest;
use Maatwebsite\Excel\Facades\Excel;
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

    public function import(Request $request)
    {

        if($request->file) {
            $original_file_name = $request->file->getClientOriginalName();
            $exploded = explode('.',$original_file_name);
            $extension = end($exploded);

            if($extension == "csv")
            {
                $path = $request->file->getRealPath();
            }else{
                return back()->withErrors('Please select the file with (.csv) extension');
            }
        }

        $data = Excel::import(new ImportController, $path);

        if($data){
            \Alert::success(trans('Data Imported Successfully'))->flash();
            return redirect('/');
        }

        
    }

}
