<?php
namespace App\Base\Helpers;

use App\Models\Response;
use App\Models\ProcessSteps;
use App\Models\RespondentData;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;

class ResponseProcessHelper{


    public static function updateProcess($id, $request, $step){
        new ResponseProcessHelper($id, $request, $step);
    }

    
     public function __construct($id, $request, $step){
        $this->performProcessUpdate($id, $request, $step);
    }

    public  function performProcessUpdate($id, $request, $step){
          // insert item in the db
        DB::beginTransaction();
        try {
            //Updating the PsBill for process step
            $response = Response::find($id);
            $next_step_id = ProcessSteps::whereStepId($response->process_step_id)->first()->next_step_id;
            $back_step_id = ProcessSteps::whereStepId($response->process_step_id)->first()->back_step_id; 
            if($response->process_step_id == 4){
                $this->saveQuestionnaire($id,'4',$request);
            }
            
            $further_step_id = $step == 'back'? $back_step_id : $next_step_id;

            switch ($further_step_id){
                case 1:
                    $this->returnBack($id, $further_step_id);
                case 2:
                    if($step == 'back'){
                        $this->returnBack($id, $further_step_id);
                    }else{
                        $this->savePersonal($id, $further_step_id,$request);
                    }
                break;
    
                case 3:
                    $this->saveQuestionnaire($id, $further_step_id, $request);
                break;

                case 4:
                    $this->saveLogistics($id, $further_step_id, $request);
                break;
                default:
                break;
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    private function returnBack($id, $further_step_id){
        // dd($further_step_id);
        $return = Response::whereId($id)->update([
            'process_step_id' => $further_step_id
        ]);

         if($return){
            \Alert::success("Redirected to Previous Page")->flash();
        }else{
            \Alert::warning('Sorry, something went wrong.')->flash();
        }
    }

    private function savePersonal($id, $further_step_id, $request){

        $personal = Response::whereId($id)->update([
            'process_step_id' => $further_step_id,
            'name_en' => $request->name_en,
            // 'name_lc' => $request->name_lc,
            'gender_id' => $request->gender_id,
            'email' => $request->email,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'local_level_id' => $request->local_level_id,
            'ward_number' => $request->ward_number,
            'gps_lat' => $request->gps_lat,
            'gps_long' => $request->gps_long,
            'remarks' => $request->remarks,
        ]);

        if($personal){
            \Alert::success("Data Updated Successsfully")->flash();
        }else{
            \Alert::warning('Sorry, something went wrong.')->flash();
        }      
    }

    private function saveQuestionnaire($id, $further_step_id, $request){
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

     $already_exists = RespondentData::whereResponseId($id)->pluck('activity_id')->toArray();
     if(count($already_exists) == 0){
        foreach($values as $val){
            $questionnaire = RespondentData::create([
                'response_id' => $id,
                'activity_id' => $val
            ]);
        }
    }else{
        $duplicate_ids [] = NULL;
        $new_ids [] = NULL;
        foreach($values as $value){
            if(in_array($value, $already_exists)){
                $duplicate_ids [] = $value; 
            }else{
                $new_ids [] = $value;
            }
        }
        $new_ids = array_filter($new_ids);
        $all_ids = array_merge($duplicate_ids, $new_ids);
        $all_ids = array_filter($all_ids);

        foreach($new_ids as $new_id){
            $questionnaire = RespondentData::create([
                'response_id' => $id,
                'activity_id' => $new_id
            ]);
        }

        //delete previously saved information if not selected this time
        $delete_ids = RespondentData::whereNotIn('activity_id',$all_ids)->delete();

    }

        $questionnaire = Response::whereId($id)->update([
            'process_step_id' => $further_step_id
        ]);

        if($questionnaire){
            \Alert::success("Data Successfully Saved ")->flash();
        }else{
            \Alert::warning('Sorry, something went wrong.')->flash();
        }
        
    }

      private function saveLogistics($id, $further_step_id, $request){

        $logistics = Response::whereId($id)->update([
            'education_id' => $request->education_id,
            'profession_id' => $request->profession_id,
            'process_step_id' => $further_step_id,
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