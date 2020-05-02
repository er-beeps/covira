<?php
namespace App\Base\Helpers;

use App\Models\Response;
use App\Models\ProcessSteps;
use App\Models\RespondentData;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

class ResponseProcessHelper{


    public static function updateProcess($id, $request){
        new ResponseProcessHelper($id, $request);
    }

    
     public function __construct($id, $request){
        $this->performProcessUpdate($id, $request);
    }

    public  function performProcessUpdate($id, $request){

          // insert item in the db
        DB::beginTransaction();
        try {
            //Updating the PsBill for process step
            $response = Response::find($id);
            $next_step_id = ProcessSteps::whereStepId($response->process_step_id)->first()->next_step_id;

            switch ($next_step_id){
                case 3:
                    $this->saveQuestionnaire($id, $next_step_id, $request);
                break;

                case 4:
                    $this->saveLogistics($id, $next_step_id, $request);
                break;
            }

            Response::whereId($id)->update([
                'process_step_id' => $next_step_id,
            ]);

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    private function saveQuestionnaire($id, $next_step_id, $request){

        $personal_travel = $request->personal_travel;
        $safety_measure = $request->safety_measure;
        $habits = $request->habits;
        $health_condition = $request->health_condition;
        $symptom = $request->symptom;

     if(!is_null($personal_travel)){
         foreach($personal_travel as $value){
             $values []=  $value;
         }
     }
     if(!is_null($safety_measure)){
         foreach($safety_measure as $value){
             $values[] =  $value;
         }
     }
     if(!is_null($habits)){
         foreach($habits as $value){
            $values[] =  $value;
         }
     }
     if(!is_null($health_condition)){
         foreach($health_condition as $value){
            $values[] =  $value;
         }
     }
     if(!is_null($symptom)){
         foreach($symptom as $value){
            $values[] =  $value;
         }
     }

        foreach($values as $val){
            $questionnaire = RespondentData::create([
                'response_id' => $id,
                'activity_id' => $val
            ]);
        }

        $questionnaire = Response::whereId($id)->update([
            'process_step_id' => $next_step_id
        ]);

        if($questionnaire){
            \Alert::success("Data Successfully Saved ")->flash();
        }else{
            \Alert::warning('Sorry, something went wrong.')->flash();
        }
        
    }

      private function saveLogistics($id, $next_step_id, $request){

        $logistics = Response::whereId($id)->update([
            'process_step_id' => $next_step_id,
            'neighbour_proximity' => $request->neighbour_proximity,
            'community_situation' => $request->community_situation,
            'confirmed_case' => $request->confirmed_case,
            'inbound_foreign_travel' => $request->inbound_foreign_travel,
            'community_population' => $request->community_population,
            'hospital_proximity' => $request->hospital_proximity,
            'corona_centre_proximity' => $request->corona_centre_proximity,
            'health_facility' => $request->health_facility,
            'market_proximity' => $request->market_proximity,
            'food_stock' => $request->food_stock,
            'agri_producer_seller' => $request->agri_producer_seller,
            'product_selling_price' => $request->product_selling_price,
            'commodity_availability' => $request->commodity_availability,
            'commodity_price_difference' => $request->commodity_price_difference,
            'job_status' => $request->job_status,
            'sustainability_duration' => $request->sustainability_duration,
        ]);

        if($logistics){
            \Alert::success("Data Submission Successsfull")->flash();
        }else{
            \Alert::warning('Sorry, something went wrong.')->flash();
        }
        
    }


}