<?php
namespace App\Base\Helpers;

use App\Models\Response;
use App\Models\PrActivity;
use App\Models\RespondentData;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

class RiskCalculationHelper{

    public function calculate_risk($id){

        $response = Response::find($id);
        $age = $response->age;
        $alpha = 8.947;
        $beta = 1.492;
        $x = (intval($age)-45.11)/27.32;

        $age_risk_factor = $alpha*exp($beta*$x);


        $a = -3.406*10*exp(-5);
        $b = 0.00673;
        $c = 0.6356; 
        $comorbidities_factor = ($a*pow($age_risk_factor,2))+($b*$age_risk_factor)+$c;

        $respondant_data = RespondentData::whereResponseId($id)->get()->toArray();

        $crf_ids = [13,14,15,17,86,87,88,89];
        $activity_ids = [];
        foreach($respondant_data as $d){
            if(in_array($d['activity_id'],$crf_ids)){
                $activity_ids []=  $d['activity_id'];
            }
        }
        

        $weight_factor_values_for_crf = PrActivity::whereIn('id',$activity_ids)
                                ->pluck('weight_factor')
                                ->toArray();

        $crf = array_sum($weight_factor_values_for_crf);

    
        $total_covid_risk_index = $age_risk_factor*((1-$comorbidities_factor)+($comorbidities_factor*$crf/100));

        $symptoms_ids = [19,20,22,23,24,25,26,27,28,29,90,91,92];
        $activities_ids = [];
        foreach($respondant_data as $d){
                 if(in_array($d['activity_id'],$symptoms_ids)){
                $activities_ids []=  $d['activity_id'];
            }
        }

        $weight_factor_values_for_symptom = PrActivity::whereIn('id',$activities_ids)
                                ->pluck('weight_factor')
                                ->toArray();

        $ss = array_sum($weight_factor_values_for_symptom);

        $other_ids = [4,5];
        $value [] = 0;
        foreach($respondant_data as $d){
            if(in_array($d['activity_id'],$other_ids)){
                $value [] =  100;
            }
        }
        $max_value = max($value);
        
        $probability_of_covid_infection = (0.8923*(0.41*$ss))+(0.1077*$max_value);

        if($total_covid_risk_index > 100){
            $total_covid_risk_index = 100;
        }
        if($probability_of_covid_infection > 100){
            $probability_of_covid_infection = 100;
        }

        $data = [
            'age_risk_factor' => $age_risk_factor,
            'covid_risk_index' => $total_covid_risk_index,
            'probability_of_covid_infection' => $probability_of_covid_infection
        ];
            Response::whereId($id)->update($data);
 }

}