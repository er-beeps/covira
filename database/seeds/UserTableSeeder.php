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
            'email' => 'super@covira.org',
            'password' => bcrypt('Super@1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@covira.org',
            'password' => bcrypt('Admin@1234'),

        ]);

        $superadmin = User::where('email','super@covira.org')->first();
        $superadmin->assignRoleCustom("superadmin");

        $admin = User::where('email','admin@covira.org')->first();
        $admin->assignRoleCustom("admin");

    }
}
