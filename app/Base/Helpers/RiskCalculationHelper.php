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

        if($age_risk_factor > 100){
            $age_risk_factor = 100;
        }


        $a = -0.0000340646579722815;
        $b = 0.0067296534381777200;
        $c = 0.6356245655700390000; 
        $comorbidities_factor = ($a*pow($age,2))+($b*$age)+$c;

        $respondant_data = RespondentData::whereResponseId($id)->get()->toArray();

//weight factor value for covid_risk_factor
        $crf_ids = [13,14,15,16,17,18,87,88];
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

        if($crf > 100){
            $crf = 100;
        }

        $total_covid_risk_index = $age_risk_factor*((1-$comorbidities_factor)+($comorbidities_factor*$crf/100));
 

// weight factor values for symptopms
        $symptoms_ids = [19,20,21,22,23,24,25,26,27,28,29,90,91];
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

//weight factor values for exposure
        $exposure_ids = [1,2,3,4,5,99,100,101,102,103];
        $exposureIds = [];
        foreach($respondant_data as $d){
            if(in_array($d['activity_id'],$exposure_ids)){
                $exposureIds [] = $d['activity_id'];
            }
        }

        $weight_factor_values_for_exposure = PrActivity::whereIn('id',$exposureIds)
                                            ->pluck('weight_factor')
                                            ->toArray();

        if(!isset($weight_factor_values_for_exposure)){
            $weight_factor_values_for_exposure = 0;
            }   
//weight factor values for habituals
        $habituals_ids = [1,2,3,4,5];
        $habitualIds = [];
        foreach($respondant_data as $d){
            if(in_array($d['activity_id'],$habituals_ids)){
                $habitualIds [] = $d['activity_id'];
            }
        }

        $weight_factor_values_for_habituals = PrActivity::whereIn('id',$habitualIds)
                                            ->pluck('weight_factor')
                                            ->toArray();
        if(!isset($weight_factor_values_for_habituals)){
            $weight_factor_values_for_habituals = 0;
        }                                    
                                            

        $merge_habitual_and_exposure = array_merge($weight_factor_values_for_exposure,$weight_factor_values_for_habituals);
        $sum_habitual_and_exposure = array_sum($merge_habitual_and_exposure);

        if($sum_habitual_and_exposure > 100){
            $sum_habitual_and_exposure = 100;
        }


//actual probability calculation formula    
        $probability_of_covid_infection = (0.8923*(0.41*$ss))+(0.1077*$sum_habitual_and_exposure);

        if($total_covid_risk_index < 0){
            $total_covid_risk_index = 0;
        }
        if($total_covid_risk_index > 100){
            $total_covid_risk_index = 100;
        }

        if($probability_of_covid_infection < 0){
            $probability_of_covid_infection = 0;
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