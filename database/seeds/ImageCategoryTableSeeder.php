<?php

use Illuminate\Database\Seeder;

class ImageCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->imagecategory();
    }

    private function imagecategory(){
    DB::table('image_category')->insert(
        [
            array('id' => 1,'code' => '1','name_en' => 'Socioeconomic Risk','name_lc' => 'सामाजिक आर्थिक जोखिम'),
            array('id' => 2,'code' => '2','name_en' => 'Public Health Risk','name_lc' => 'जन स्वास्थ्य जोखिम'),
            array('id' => 3,'code' => '3','name_en' => 'Food Productivity Map','name_lc' => 'खाद्य उत्पादकत्व'),
            array('id' => 4,'code' => '4','name_en' => 'Transmission Risk','name_lc' => 'सर्ने फैलिने जोखिम'),
            array('id' => 5,'code' => '5','name_en' => 'Overall Risk','name_lc' => 'सापेक्षित जोखिम')

        ]
    );

    DB::statement("SELECT SETVAL('image_category_id_seq',100)");
    }

}
