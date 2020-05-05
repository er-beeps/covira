<?php

namespace App\Http\Controllers;

use DB;
use Charts;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class GisMapController extends Controller
{
    public function index()
    {
        // $client_id = \App\User::getSystemUserId();
        // $this->data['list_tab_header_view'] = 'admin.gismap.tab';

        $sql = "SELECT 
                r.id,
                r.code,
                d.name_lc as district_name_np,
                d.name_en as district_name_en,
                r.name_en,
                r.name_lc,
                ll.name_lc locallevel,
                ll.name_en enlocallevel,
                COALESCE (cast(nullif(r.gps_lat, '') as float), 27.700769) lat,
                COALESCE (cast(nullif(r.gps_long, '') as float), 85.300140 ) lon
                FROM response r
                LEFT JOIN mst_fed_local_level AS ll ON r.local_level_id = ll.id
                LEFT JOIN mst_fed_district d ON ll.district_id = d.id
                LEFT JOIN mst_fed_province pr ON d.province_id = pr.id
                ";

//search criteria
$params = [];
$wheres = [];
$data = null;
$request = request();
if ($request->all() != null) {
    $Province = $request->province;
    $District = $request->district;
    $Local_Level = $request->local_level;

    if (!empty($Province)) {
        $wheres[] =  'and d.province_id = :province';
        $params[":province"] = $Province;
    }

    if (!empty($District)) {
        $wheres[] =  'and ll.district_id = :district';
        $params[":district"] = $District;
    }
    if (!empty($Local_Level)) {
        $wheres[] =  'and r.local_level_id = :local_level';
        $params[":local_level"] = $Local_Level;
    }
   
    // dd($wheres);
    if (count($wheres) > 0) {
        $where_clause = " WHERE 1=1 " . implode(" ", $wheres);
        $sql .= $where_clause;
    }
    $gps = DB::select($sql, $params);
} else {   
    $gps = DB::select($sql);
    
        $markers = json_encode($gps);
        $area_province = DB::select('select id, code,name_en,name_lc from mst_fed_province as p	WHERE id in (SELECT distinct province_id FROM mst_fed_district where id in (SELECT distinct district_id from mst_fed_local_level)) order by code asc');

        $selected_params = array();
        foreach ($params as $key => $val) {
            $selected_params[str_replace(":", "", $key)] = $val;
        }


        return view('gismap', compact('markers','area_province','gps', 'selected_params'));
       
     }
     }

}

