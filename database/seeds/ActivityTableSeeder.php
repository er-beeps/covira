<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
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

    private function pr_activity(){
         DB::table('pr_activity')->insert([
              array('id' => 1, 'code' => '1', 'name_en' => 'Work in hospitals/healthposts/carehomes/pharmacy', 'name_lc' => 'Work in hospitals/healthposts/carehomes/pharmacy','factor_id' => 1 ,'weight_factor' => 75),
              array('id' => 2, 'code' => '2', 'name_en' => 'Driving public vehicles', 'name_lc' => 'Driving public vehicles' ,'factor_id' => 1 ,'weight_factor' => 75),
              array('id' => 3, 'code' => '3', 'name_en' => 'Need to attend meetings in person occasionally', 'name_lc' => 'Need to attend meetings in person occasionally','factor_id' => 1 ,'weight_factor' => 50),
              array('id' => 4, 'code' => '4', 'name_en' => 'Arrived from India or other foreign country with in a month', 'name_lc' => 'Arrived from India or other foreign country wiht in a month','factor_id' => 1 ,'weight_factor' => 100),
              array('id' => 5, 'code' => '5', 'name_en' => 'Meet with COVID19 infected person', 'name_lc' => 'Meet with COVID19 infected person','factor_id' => 1 ,'weight_factor' => 100),
              array('id' => 93, 'code' => '93', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 1 ,'weight_factor' => 0),

              array('id' => 6, 'code' => '6', 'name_en' => 'Wear mask when going to crowded areas', 'name_lc' => 'Wear mask when going outside','factor_id' => 2 ,'weight_factor' => -5),
              array('id' => 7, 'code' => '7', 'name_en' => 'Sanitize hands time by time', 'name_lc' => 'Sanitize hands time by time','factor_id' => 2 ,'weight_factor' => -10),
              array('id' => 8, 'code' => '8', 'name_en' => 'Maintain physical distance when going outside', 'name_lc' => 'Maintain physical distance when going outside','factor_id' => 2 ,'weight_factor' => -10),
              array('id' => 94, 'code' => '94', 'name_en' => 'Used gloves when handling purchased item', 'name_lc' => 'Used gloves when handling purchased item','factor_id' => 2 ,'weight_factor' => -10),
              array('id' => 95, 'code' => '95', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 2 ,'weight_factor' => 10),

              array('id' => 9, 'code' => '9', 'name_en' => 'Smoke regularly', 'name_lc' => 'Smoke regularly','factor_id' => 3 ,'weight_factor' => 30),
              array('id' => 10, 'code' => '10', 'name_en' => 'Drink Alcohol Regularly', 'name_lc' => 'Drink Alcohol Regularly','factor_id' => 3 ,'weight_factor' => 30),
              array('id' => 11, 'code' => '11', 'name_en' => 'Take Drugs Regularly', 'name_lc' => 'Take Drugs Regularly','factor_id' => 3 ,'weight_factor' => 30),
              array('id' => 12, 'code' => '12', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 3 ,'weight_factor' => 0),

              array('id' => 13, 'code' => '13', 'name_en' => 'Asthma/Chronic obstructive pulmonary disease', 'name_lc' => 'Asthma/Chronic obstructive pulmonary disease','factor_id' => 4 ,'weight_factor' => 100),
              array('id' => 14, 'code' => '14', 'name_en' => 'Cardiovascular/Coronary heart disease', 'name_lc' => 'Cardiovascular/Coronary heart disease','factor_id' => 4 ,'weight_factor' => 99),
              array('id' => 15, 'code' => '15', 'name_en' => 'Renal Disease', 'name_lc' => 'Renal Disease','factor_id' => 4 ,'weight_factor' => 90),
              array('id' => 16, 'code' => '16', 'name_en' => 'Hypertension', 'name_lc' => 'Hypertension','factor_id' => 4 ,'weight_factor' => 54),
              array('id' => 17, 'code' => '17', 'name_en' => 'Cancer(including treated within 3 years)', 'name_lc' => 'Cancer(including treated within 3 years)','factor_id' => 4 ,'weight_factor' => 54),
              array('id' => 18, 'code' => '18', 'name_en' => 'Diabetes', 'name_lc' => 'Diabetes','factor_id' => 4 ,'weight_factor' => 69),

              array('id' => 87, 'code' => '87', 'name_en' => 'Obesity', 'name_lc' => 'Obesity','factor_id' => 4 ,'weight_factor' => 54),
              array('id' => 88, 'code' => '88', 'name_en' => 'Cerebrovascular disease', 'name_lc' => 'Cerebrovascular disease','factor_id' => 4 ,'weight_factor' => 48),
              array('id' => 89, 'code' => '89', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 4 ,'weight_factor' => 0),



              array('id' => 19, 'code' => '19', 'name_en' => 'High fever', 'name_lc' => 'High fever','factor_id' => 5 ,'weight_factor' => 100),
              array('id' => 20, 'code' => '20', 'name_en' => 'Cough', 'name_lc' => 'Cough','factor_id' => 5 ,'weight_factor' => 87),
              array('id' => 21, 'code' => '21', 'name_en' => 'Chills', 'name_lc' => 'Chills','factor_id' => 5 ,'weight_factor' => 13),
              array('id' => 22, 'code' => '22', 'name_en' => 'Fatigue', 'name_lc' => 'Fatigue','factor_id' => 5 ,'weight_factor' => 34),
              array('id' => 23, 'code' => '23', 'name_en' => 'Shortness of breathe', 'name_lc' => 'Shortness of breathe','factor_id' => 5 ,'weight_factor' => 57),
              array('id' => 24, 'code' => '24', 'name_en' => 'Throat pain', 'name_lc' => 'Throat pain','factor_id' => 5 ,'weight_factor' => 18),
              array('id' => 25, 'code' => '25', 'name_en' => 'Headache', 'name_lc' => 'Headache','factor_id' => 5 ,'weight_factor' => 17),
              array('id' => 26, 'code' => '26', 'name_en' => 'Body pain (Myalgia)', 'name_lc' => 'Body pain (Myalgia)','factor_id' => 5 ,'weight_factor' => 24),
              array('id' => 27, 'code' => '27', 'name_en' => 'Nausea and Vomitting', 'name_lc' => 'Nausea and Vomitting','factor_id' => 5 ,'weight_factor' => 13),
              array('id' => 28, 'code' => '28', 'name_en' => 'Nasal congestion', 'name_lc' => 'Nasal congestion','factor_id' => 5 ,'weight_factor' => 12),
              array('id' => 29, 'code' => '29', 'name_en' => 'Diarrhoea', 'name_lc' => 'Diarrhoea','factor_id' => 5 ,'weight_factor' => 14),

                
              array('id' => 90, 'code' => '90', 'name_en' => 'Sputum Production', 'name_lc' => 'Sputum Production','factor_id' => 5 ,'weight_factor' => 31),
              array('id' => 91, 'code' => '91', 'name_en' => 'Chest pain', 'name_lc' => 'Chest pain','factor_id' => 5 ,'weight_factor' => 17),
              array('id' => 92, 'code' => '92', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 5 ,'weight_factor' => 0),

              array('id' => 30, 'code' => '30', 'name_en' => 'upto 5', 'name_lc' => 'upto 5','factor_id' => 6 ,'weight_factor' => 50),
              array('id' => 31, 'code' => '31', 'name_en' => 'More than 5', 'name_lc' => 'More than 5','factor_id' => 6 ,'weight_factor' => 100),
              array('id' => 32, 'code' => '32', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 6 ,'weight_factor' => 0),

              array('id' => 33, 'code' => '33', 'name_en' => 'Fully locked down', 'name_lc' => 'Fully locked down','factor_id' => 7,'weight_factor' => 0),
              array('id' => 34, 'code' => '34', 'name_en' => 'Essential shops/services are open for specific time', 'name_lc' => 'Essential shops/services are open for specific time','factor_id' => 7,'weight_factor' => 20),
              array('id' => 35, 'code' => '35', 'name_en' => 'Essential shops/services are open normally', 'name_lc' => 'Essential shops/services are open normally','factor_id' => 7,'weight_factor' => 40),
              array('id' => 36, 'code' => '36', 'name_en' => 'All shops/businessess open for specific time', 'name_lc' => 'All shops/businessess open for specific time','factor_id' => 7,'weight_factor' => 80),
              array('id' => 37, 'code' => '37', 'name_en' => 'Everything as normal', 'name_lc' => 'Everything as normal','factor_id' => 7,'weight_factor' => 100),

              array('id' => 38, 'code' => '38', 'name_en' => 'Lost job', 'name_lc' => 'Lost job','factor_id' => 8,'weight_factor' => 100),
              array('id' => 39, 'code' => '39', 'name_en' => 'Have to close business', 'name_lc' => 'Have to close business','factor_id' => 8,'weight_factor' => 100),
              array('id' => 40, 'code' => '40', 'name_en' => 'Reduced salary', 'name_lc' => 'Reduced salary','factor_id' => 8,'weight_factor' => 50),
              array('id' => 41, 'code' => '41', 'name_en' => 'Loss on business but will be continued', 'name_lc' => 'Loss on business but will be continued','factor_id' => 8,'weight_factor' => 50),
              array('id' => 42, 'code' => '42', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 8,'weight_factor' => 0),

              array('id' => 43, 'code' => '43', 'name_en' => 'Less than 5', 'name_lc' => 'Less than 5','factor_id' => 9,'weight_factor' => 50),
              array('id' => 44, 'code' => '44', 'name_en' => 'More than 5', 'name_lc' => 'More than 5','factor_id' => 9,'weight_factor' => 100),
              array('id' => 45, 'code' => '45', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 9,'weight_factor' => 0),

              array('id' => 46, 'code' => '46', 'name_en' => 'Upto 5', 'name_lc' => 'Upto 5','factor_id' => 10,'weight_factor' => 30),
              array('id' => 47, 'code' => '47', 'name_en' => '6-20', 'name_lc' => '6-20','factor_id' => 10,'weight_factor' => 60),
              array('id' => 48, 'code' => '48', 'name_en' => 'More than 20', 'name_lc' => 'More than 20','factor_id' => 10,'weight_factor' => 100),
              array('id' => 49, 'code' => '49', 'name_en' => 'None', 'name_lc' => 'None','factor_id' => 10,'weight_factor' => 0),

              array('id' => 50, 'code' => '50', 'name_en' => 'Upto 500', 'name_lc' => 'Upto 500','factor_id' => 11,'weight_factor' => 10),
              array('id' => 51, 'code' => '51', 'name_en' => '501-2000', 'name_lc' => '501-2000','factor_id' => 11,'weight_factor' => 50),
              array('id' => 52, 'code' => '52', 'name_en' => 'More than 2000', 'name_lc' => 'More than 2000','factor_id' => 11,'weight_factor' => 100),

              array('id' => 53, 'code' => '53', 'name_en' => 'Within 1 km', 'name_lc' => 'Within 1 km','factor_id' => 12,'weight_factor' => 0),
              array('id' => 54, 'code' => '54', 'name_en' => '1-5 km', 'name_lc' => '1-5 km','factor_id' => 12,'weight_factor' => 50),
              array('id' => 55, 'code' => '55', 'name_en' => 'More than 5 km', 'name_lc' => 'More than 5 km','factor_id' => 12,'weight_factor' => 100),

              array('id' => 56, 'code' => '56', 'name_en' => 'Well equiped with enough doctors', 'name_lc' => 'Well equiped with enough doctors','factor_id' => 14,'weight_factor' => 0),
              array('id' => 57, 'code' => '57', 'name_en' => 'Doctors are enough but treatment facilities are limited', 'name_lc' => 'Doctors are enough but treatment facilities are limited','factor_id' => 14,'weight_factor' => 30),
              array('id' => 58, 'code' => '58', 'name_en' => 'Both doctors and facilities are limited', 'name_lc' => 'Both doctors and facilities are limited','factor_id' => 14,'weight_factor' => 60),
              array('id' => 59, 'code' => '59', 'name_en' => 'No doctors(only HA or Other staffs) and limited facilities', 'name_lc' => 'No doctors(only HA or Other staffs) and limited facilities','factor_id' => 14,'weight_factor' => 100),

              array('id' => 60, 'code' => '60', 'name_en' => '5 minutes walking', 'name_lc' => '5 minutes walking','factor_id' => 15,'weight_factor' => 0),
              array('id' => 61, 'code' => '61', 'name_en' => '20 minutes walking', 'name_lc' => '20 minutes walking','factor_id' => 15,'weight_factor' => 0),
              array('id' => 62, 'code' => '62', 'name_en' => '60 minutes walking', 'name_lc' => '60 minutes walking','factor_id' => 15,'weight_factor' => 0),
              array('id' => 63, 'code' => '63', 'name_en' => 'More than 60 minutes walking', 'name_lc' => 'More than 60 minutes walking','factor_id' => 15,'weight_factor' => 0),

              array('id' => 64, 'code' => '64', 'name_en' => 'Less than 1 week', 'name_lc' => 'Less than 1 week','factor_id' => 16,'weight_factor' => 0),
              array('id' => 65, 'code' => '65', 'name_en' => '1 week', 'name_lc' => '1 week','factor_id' => 16,'weight_factor' => 0),
              array('id' => 66, 'code' => '66', 'name_en' => '2 weeks', 'name_lc' => '2 weeks','factor_id' => 16,'weight_factor' => 0),
              array('id' => 67, 'code' => '67', 'name_en' => '3 weeks', 'name_lc' => '3 weeks','factor_id' => 16,'weight_factor' => 0),
              array('id' => 68, 'code' => '68', 'name_en' => '1 month', 'name_lc' => '1 month','factor_id' => 16,'weight_factor' => 0),
              array('id' => 69, 'code' => '69', 'name_en' => 'More than 1 month', 'name_lc' => 'More than 1 month','factor_id' => 16,'weight_factor' => 0),

              array('id' => 70, 'code' => '70', 'name_en' => 'Yes', 'name_lc' => 'Yes','factor_id' => 17,'weight_factor' => 0),
              array('id' => 71, 'code' => '71', 'name_en' => 'No', 'name_lc' => 'No','factor_id' => 17,'weight_factor' => 0),

              array('id' => 72, 'code' => '72', 'name_en' => 'Yes', 'name_lc' => 'Yes','factor_id' => 18,'weight_factor' => 0),
              array('id' => 73, 'code' => '73', 'name_en' => 'No', 'name_lc' => 'No','factor_id' => 18,'weight_factor' => 0),

              array('id' => 74, 'code' => '74', 'name_en' => 'Normal', 'name_lc' => 'Normal','factor_id' => 19,'weight_factor' => 0),
              array('id' => 75, 'code' => '75', 'name_en' => 'Shortage', 'name_lc' => 'Shortage','factor_id' => 19,'weight_factor' => 0),
              array('id' => 76, 'code' => '76', 'name_en' => 'Access', 'name_lc' => 'Access','factor_id' => 19,'weight_factor' => 0),

              array('id' => 77, 'code' => '77', 'name_en' => 'As before', 'name_lc' => 'As before','factor_id' => 20,'weight_factor' => 0),
              array('id' => 78, 'code' => '78', 'name_en' => 'Expensive than before', 'name_lc' => 'Expensive than before','factor_id' => 20,'weight_factor' => 0),
              array('id' => 79, 'code' => '79', 'name_en' => 'Cheaper than before', 'name_lc' => 'Cheaper than before','factor_id' => 20,'weight_factor' => 0),

              array('id' => 80, 'code' => '80', 'name_en' => 'Yes', 'name_lc' => 'Yes','factor_id' => 21,'weight_factor' => 0),
              array('id' => 81, 'code' => '81', 'name_en' => 'No', 'name_lc' => 'No','factor_id' => 21,'weight_factor' => 0),

              array('id' => 82, 'code' => '82', 'name_en' => '1 week', 'name_lc' => '1 week','factor_id' => 22,'weight_factor' => 0),
              array('id' => 83, 'code' => '83', 'name_en' => '1 month', 'name_lc' => '1 month','factor_id' => 22,'weight_factor' => 0),
              array('id' => 84, 'code' => '84', 'name_en' => '3 months', 'name_lc' => '3 months','factor_id' => 22,'weight_factor' => 0),
              array('id' => 85, 'code' => '85', 'name_en' => '1 year', 'name_lc' => '1 year','factor_id' => 22,'weight_factor' => 0),
              ]);

             DB::statement("SELECT SETVAL('pr_activity_id_seq',100)");
              
    }
}
