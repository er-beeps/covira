<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Base\BaseCrudController;
use App\Imports\ImportController;
use Illuminate\Support\Facades\DB;
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

    public function export()
    {
        $datas= DB::select('SELECT (row_number() over (order by r.id)) as rnum,r.code as code, r.name_en as english_name,r.name_lc as nepali_name,g.name_en as gender,r.age, r.email,
                            r.is_other_country,c.name_en as country,r.city, fp.name_en as province,d.name_en as district,ll.name_en as local_level,r.ward_number,edu.name_en as education,
                            prf.name_en as profession,r.gps_lat,r.gps_long,r.age_risk_factor,r.covid_risk_index,r.probability_of_covid_infection,
                             np.name_en as neighbour_proximity,cs.name_en as community_situation,cc.name_en as confirmed_case,ift.name_en as inbound_foreign_travel,
                             cp.name_en as community_population,hop.name_en as hospital_proximity,ccp.name_en as corona_centre_proximity,hp.name_en as health_facility,
                             mp.name_en as market_proximity,fs.name_en as food_stock,aps.name_en as agri_producer_seller,psp.name_en as product_selling_price,
                             ca.name_en as commodity_availability,cpd.name_en as commodity_price_difference,js.name_en as job_status,ei.name_en as economic_impact,
                             sd.name_en as sustainability_duration
                              from response r 
                            LEFT JOIN mst_country as c on r.country_id = c.id
                            LEFT JOIN mst_fed_province as fp on r.province_id = fp.id
                            LEFT JOIN mst_fed_district as d on r.district_id = d.id
                            LEFT JOIN mst_fed_local_level as ll on r.local_level_id = ll.id
                            LEFT JOIN mst_educational_level as edu on r.education_id = edu.id
                            LEFT JOIN mst_profession as prf on r.profession_id = prf.id
                            LEFT JOIN mst_gender as g on r.gender_id = g.id
                            LEFT JOIN pr_activity as np on r.neighbour_proximity = np.id
                            LEFT JOIN pr_activity as cs on r.community_situation = cs.id
                            LEFT JOIN pr_activity as cc on r.confirmed_case = cc.id
                            LEFT JOIN pr_activity as ift on r.inbound_foreign_travel = ift.id
                            LEFT JOIN pr_activity as cp on r.community_population = cp.id
                            LEFT JOIN pr_activity as hop on r.hospital_proximity = hop.id
                            LEFT JOIN pr_activity as ccp on r.corona_centre_proximity = ccp.id
                            LEFT JOIN pr_activity as hp on r.health_facility = hp.id
                            LEFT JOIN pr_activity as mp on r.market_proximity = mp.id
                            LEFT JOIN pr_activity as fs on r.food_stock = fs.id
                            LEFT JOIN pr_activity as aps on r.agri_producer_seller = aps.id
                            LEFT JOIN pr_activity as psp on r.product_selling_price = psp.id
                            LEFT JOIN pr_activity as ca on r.commodity_availability = ca.id
                            LEFT JOIN pr_activity as cpd on r.commodity_price_difference = cpd.id
                            LEFT JOIN pr_activity as js on r.job_status = js.id
                            LEFT JOIN pr_activity as ei on r.economic_impact = ei.id
                            LEFT JOIN pr_activity as sd on r.sustainability_duration = sd.id');

        $this->data['datas'] = $datas;

        $excel_sheet = new \App\Exports\ExcelExport('excel_export.response',$this->data);

        ob_end_clean();
        ob_start();
        return Excel::download($excel_sheet, 'response_data.xlsx');

    }

}
