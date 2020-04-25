<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function assignRoleCustom($role_name){
        
        $roleModel = Role::where('name', $role_name)
        ->take(1)
        ->get();

        if(count($roleModel) == 0){
            return "role doesnot exists";
        }
        DB::table('model_has_roles')->insert([
            'role_id' => $roleModel[0]->id,
            'model_type' => 'App\Models\BackpackUser',
            'model_id' => $this->id
        ]);
    }

    public function roles(): MorphToMany
    {
        $superadmin_role = Role::where('name', 'superadmin')
        ->first();

        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            'role_id'
        );
    }
}
