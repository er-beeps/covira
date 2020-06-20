<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->pr_factor();
    }

    private function pr_factor(){
        DB::table('pr_factor')->insert([
            array('id' => 1,'code' => '1','name_en' => 'Occupation','name_lc' => 'Occupation'),
            array('id' => 2,'code' => '2','name_en' => 'Exposure','name_lc' => 'Exposure'),
            array('id' => 3,'code' => '3','name_en' => 'Safety Measure','name_lc' => 'Safety Measure'),
            array('id' => 4,'code' => '4','name_en' => 'Habit','name_lc' => 'Habit'),
            array('id' => 5,'code' => '5','name_en' => 'Health Condition','name_lc' => 'Health Condition'),
            array('id' => 6,'code' => '6','name_en' => 'Symptom','name_lc' => 'Symptom'),
            array('id' => 7,'code' => '7','name_en' => 'Neighbour Proximity','name_lc' => 'Neighbour Proximity'),
            array('id' => 8,'code' => '8','name_en' => 'Community Situation','name_lc' => 'Community Situation'),
            array('id' => 9,'code' => '9','name_en' => 'Economic Impact','name_lc' => 'Economic Impact'),
            array('id' => 10,'code' => '10','name_en' => 'Confirmed Case','name_lc' => 'Confirmed Case'),
            array('id' => 11,'code' => '11','name_en' => 'Inbound Foreign Travel','name_lc' => 'Inbound Foreign Travel'),
            array('id' => 12,'code' => '12','name_en' => 'Community Population','name_lc' => 'Community Population'),
            array('id' => 13,'code' => '13','name_en' => 'Hospital Proximity','name_lc' => 'Hospital Proximity'),
            array('id' => 14,'code' => '14','name_en' => 'Corona Centre Proximity','name_lc' => 'Corona Centre Proximity'),
            array('id' => 15,'code' => '15','name_en' => 'Health Facility','name_lc' => 'Health Facility'),
            array('id' => 16,'code' => '16','name_en' => 'Market Proximity','name_lc' => 'Market Proximity'),
            array('id' => 17,'code' => '17','name_en' => 'Food Stock','name_lc' => 'Food Stock'),
            array('id' => 18,'code' => '18','name_en' => 'Agri Producer Seller','name_lc' => 'Agri Producer Seller'),
            array('id' => 19,'code' => '19','name_en' => 'Product Selling Price','name_lc' => 'Product Selling Price'),
            array('id' => 20,'code' => '20','name_en' => 'Commodity Availability','name_lc' => 'Commodity Availability'),
            array('id' => 21,'code' => '21','name_en' => 'Commodity Price Difference','name_lc' => 'Commodity Price Difference'),
            array('id' => 22,'code' => '22','name_en' => 'Job Status','name_lc' => 'Job Status'),
            array('id' => 23,'code' => '23','name_en' => 'Sustainability','name_lc' => 'Sustainability'),
           

        ]);
        DB::statement("SELECT SETVAL('pr_factor_id_seq',100)");

    }
}
