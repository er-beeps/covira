<?php

use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->step_master();
        $this->process_steps();
    }

        private function step_master(){
        DB::table('step_master')->insert(
            [
                array('id' => 1,'code' => '1','name_en' => 'Personal Details','name_lc' => 'Personal Details','current_step_name_en' => 'Personal Details','current_step_name_lc' => 'Personal Details'),
                array('id' => 2,'code' => '2','name_en' => 'Questionnaire','name_lc' => 'Questionnaire','current_step_name_en' => 'Questionnaire','current_step_name_lc' => 'Questionnaire'),
                array('id' => 3,'code' => '3','name_en' => 'Logistics','name_lc' => 'Logistics','current_step_name_en' => 'Logistics','current_step_name_lc' => 'Logistics'),

            ]
            );
            DB::statement("SELECT SETVAL('step_master_id_seq',1000)");
    }


    private function process_steps(){
        DB::table('process_steps')->insert(
            [
            array('id'=>1,'code'=>'1','step_id'=>1, 'next_step_id'=> 2, 'is_first_step'=>true,'is_active'=>true),
            array('id'=>2,'code'=>'2','step_id'=>2, 'next_step_id'=> 3, 'is_first_step'=>false,'is_active'=>true),
            array('id'=>3,'code'=>'3','step_id'=>3, 'next_step_id'=> NULL, 'is_first_step'=>false,'is_active'=>true),

        ]
    );
        DB::statement("SELECT SETVAL('process_steps_id_seq',1000)");

    }

    
}
