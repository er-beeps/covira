<?php

namespace App\Models;

use App\Base\BaseModel;
use App\Base\DataAccessPermission;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class MstEducationalLevel extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $dataAccessPermission = DataAccessPermission::SystemOnly;

    protected $table = 'mst_educational_level';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','created_by','updated_by'];
    protected $fillable = ['code','name_en','name_lc','display_order','remarks'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
