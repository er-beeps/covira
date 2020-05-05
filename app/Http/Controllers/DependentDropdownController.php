<?php

namespace App\Http\Controllers;

use App\Models\MstDistrict;
use App\Models\MstProvince;
use App\Models\MstLocalLevel;
use App\Models\NepaliMonth;
// use App\unit_type;
// use App\Base\AccessCrudController as CrudController;

class DependentDropdownController extends Controller
{

    public function index()
    {
        $province = MstProvince::all();
        return view('gismap', compact('province_id'));
    }

    public function getdistrict($id)
    {
        $district = MstDistrict::where('province_id', $id)->whereRaw("id in (SELECT distinct district_id from mst_fed_local_level)")->get();
        return response()->json($district);
    }
    public function getlocal_level($id)
    {
        $local_level = MstLocalLevel::where('district_id', $id)->get();
        return response()->json($local_level);
    }
  

    // public function getunittype($id)
    // {
        
    //     //  $unittype = unit_type::where('id',$id)->get();
    //     $unittype = unit_type::leftjoin('mst_unit','pt_project.unit_type','=','mst_unit.id')->where('pt_project.id',$id)->get();
    //     return response()->json($unittype);
    // }

    // public function getTimeofreport($id)
    // {
    //     if ($id == 1) {
    //         $Time_of_report = NepaliMonth::all();
    //     } elseif ($id == 2) {
    //         $Time_of_report = NepaliMonth::where('is_quarterly', '1')->get();
    //     } elseif ($id == 3) {
    //         $Time_of_report = NepaliMonth::where('is_yearly', '1')->get();
    //     } elseif ($id == 4) {
    //         $Time_of_report = NepaliMonth::where('is_halfyearly', '1')->get();
    //     }
    //     return response()->json($Time_of_report);
    // }
}
