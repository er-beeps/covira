<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NepalDataCovid;
use Illuminate\Support\Facades\Http;

class ScrapController extends Controller
{

    public function __invoke(){

        $response = Http::get('https://covid19.mohp.gov.np/covid/api/confirmedcases');

        $nepal_data = $response->json()['nepal'];


        $data = [
            'total_swab_test' => $nepal_data['samples_tested'],
            'total_affected' => $nepal_data['positive'],
            'total_recovered' => $nepal_data['extra1'],
            'total_isolation' => $nepal_data['extra2'],
            'total_death' => $nepal_data['deaths'],
            'total_quarantine' => $nepal_data['extra8'],

            'new_pcr' => $nepal_data['today_pcr'],
            'new_cases' => $nepal_data['today_newcase'],
            'new_recovered' => $nepal_data['today_recovered'],
            'new_death' => $nepal_data['today_death'],
            'updated_timestamp' => $nepal_data['updated_at']
            ];

            $latest_covid_data = NepalDataCovid::latest('created_at')->limit(1)->first();

            $prev_updated_timestamp = $latest_covid_data->updated_timestamp;
            $current_timestamp = $nepal_data['updated_at'];


            if($prev_updated_timestamp !== $current_timestamp){
                NepalDataCovid::create($data);

            }
            return back();
    }

}
