<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(PrimaryMasterTableSeeder::class);
        $this->call(DateSettingTableSeeder::class);
        $this->call(FactorTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(ProcessSeeder::class);
    }
}
