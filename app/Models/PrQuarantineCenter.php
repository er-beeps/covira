<?php

namespace App\Models;

use App\Base\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class PrQuarantineCenter extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pr_quarantine_center';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','created_by','updated_by'];
    protected $fillable = ['code','name_en','name_lc','province_id','district_id','local_level_id','ward_number','gps_lat','gps_long','capacity','num_ventilator','num_icu','display_order','remarks'];
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
    public function province()
    {
        return $this->belongsTo('App\Models\MstProvince','province_id','id');
    }
    public function district()
    {
        return $this->belongsTo('App\Models\MstDistrict','district_id','id');
    }
    public function locallevel()
    {
        return $this->belongsTo('App\Models\MstLocalLevel','local_level_id','id');
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
    public function getProvinceDistrictAttribute()
    {
        return $this->province->name_lc.'<br>'.$this->district->name_lc;
    }
    
    public function getLocalAddressAttribute()
    {
        return $this->locallevel->name_lc.'<br>'.$this->ward_number;
    }
}
