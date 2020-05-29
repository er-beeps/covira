<?php


use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin_role = Role::create(['name' => 'superadmin']);
        $admin_role = Role::create(['name' => 'admin']);
        $normal_role = Role::create(['name' => 'normal']);
    
        

        // DB::table("")
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'super@covid.org',
            'password' => bcrypt('Admin@1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@covid.org',
            'password' => bcrypt('Admin@1234'),

        ]);

        $superadmin = User::where('email','super@covid.org')->first();
        $superadmin->assignRoleCustom("superadmin");

        $admin = User::where('email','admin@covid.org')->first();
        $admin->assignRoleCustom("admin");

    }
}
