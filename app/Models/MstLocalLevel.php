<?php

namespace App\Models;

use App\Base\BaseModel;
use App\Base\DataAccessPermission;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class MstLocalLevel extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $dataAccessPermission = DataAccessPermission::SystemOnly;

    protected $table = 'mst_fed_local_level';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['district_id','code','name_en','name_lc','level_type_id','wards_count','is_tmpp_applicable','remarks','created_by','updated_by','gps_lat','gps_long'];
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
    public function district(){
        return $this->belongsTo('App\Models\MstDistrict','district_id','id');
    }

    public function localleveltype(){
        return $this->belongsTo('App\Models\MstLocalLevelType','level_type_id','id');
    }

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
