<?php

use Illuminate\Database\Seeder;

class ExtraActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->pr_activity();
    }

    public function pr_activity(){
      
        DB::table('pr_activity')->insert([
            array('id' => 99, 'code' => '99', 'name_en' => 'Go for shopping and grocery', 'name_lc' => 'Go for shopping and grocery','factor_id' => 1 ,'weight_factor' => 25),
            array('id' => 100, 'code' => '100', 'name_en' => 'Travel in public vehicle occasionally', 'name_lc' => 'Travel in public vehicle occasionally','factor_id' => 1 ,'weight_factor' => 40),
            array('id' => 101, 'code' => '101', 'name_en' => 'Need to meet with public as a part of job', 'name_lc' => 'Need to meet with public as a part of job','factor_id' => 1 ,'weight_factor' => 50),
            array('id' => 102, 'code' => '102', 'name_en' => 'Works in shops or supermarkets', 'name_lc' => 'Works in shops or supermarkets','factor_id' => 1 ,'weight_factor' => 60),
            array('id' => 103, 'code' => '103', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 1 ,'weight_factor' => 0),

        ]);

        DB::table('respondent_data')->where('activity_id',93)->update(['activity_id'=>103]);
        DB::table('pr_activity')->where('id',93)->delete();


    }
}
