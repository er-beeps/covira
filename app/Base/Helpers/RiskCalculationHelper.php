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

        $required_ids = [13,14,15,17,86,87,88,89];
        foreach($respondant_data as $data){
            if(in_array($data['activity_id'],$required_ids)){
                $activity_ids []=  $data['activity_id'];
            }
        }
        

        $wieght_factor_values = PrActivity::whereIn('id',$activity_ids)
                                ->pluck('weight_factor')
                                ->toArray();

        $crf = array_sum($wieght_factor_values);

    
        $total_covid_risk_index = $age_risk_factor*((1-$comorbidities_factor)+($comorbidities_factor*$crf/100));
        dd($total_covid_risk_index);


}

}