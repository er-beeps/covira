<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Models\MstDistrict;
use App\Models\MstProvince;
use Illuminate\Http\Request;
use App\Models\MstLocalLevel;
use Illuminate\Support\Facades\Input;


class BasicController extends Controller
{
    public function redirectResult(){
        return view('result_viewer');
    }

    public function redirectRegionalResult(){
        return view('regionalrisk_view');
    }

    public function redirectAbout(){
        return view('about_view');
    }

    public function redirectTeams(){
        return view('team_view');
    }

    public function incrementLike(Request $request){
        $has_liked  = request()->session()->get('action');
        // dd(request()->session());
        if($has_liked){
        }else{
            request()->session()->put('action','like');
          //if the user click on "like"
            DB::table('counter_info')->update(['like_counter'=>DB::raw('like_counter+1')]);
        }

        $like_count = DB::table('counter_info')->pluck('like_counter')->first();    
        
        return response()->json([
                'message' => 'success',
                'like_count' => $like_count,
            ]);
    }

   
    public function fetchImg(Request $request){
        $img_category_id = $request->id;
        $risk_map = DB::table('image_upload')
                            ->select('image_path')
                            ->where('image_category_id',$img_category_id)
                            ->orderby('created_at','desc')
                            ->limit(1)
                            ->get();

        if($risk_map->count()>0){                                 // dd($risk_map);
        $risk_map_path = $risk_map[0]->image_path;
        }else{
            $risk_map_path ='';
        }

        return view('imageviewer',compact('risk_map_path'));
    }


    public function getRegionalRisk(Request $request){

        $ProvinceId = $request->province;
        $DistrictId = $request->district;
        $LocalLevelId = $request->local_level;

        $province = MstProvince::find($ProvinceId);
        $district = MstDistrict::find($DistrictId);
        $local_level = MstLocalLevel::find($LocalLevelId);

        if($province){
        $province_name = $province->name_lc;
        request()->session()->put('province',$province_name);
        }
        if($district){
        $district_name = $district->name_lc;
        request()->session()->put('district',$district_name);
        }

        if($local_level){
        $local_level_code = $local_level->code;
        $local_level_name = $local_level->name_lc;
        $rtr = DB::table('dt_risk_transmission')->where('code',$local_level_code)->pluck('ctr')->first();
        request()->session()->put('local_level_name',$local_level_name);
        request()->session()->put('rtr',$rtr);
        request()->session()->put('key',0);
        }

        // return view('regionalrisk_view',compact('province_name','district_name','local_level_name','rtr'));
        return redirect(url('/'));
    }
    
}


