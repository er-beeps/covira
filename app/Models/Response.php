<?php

namespace App\Models;

use App\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Response extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'response';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','created_by','updated_by'];
    protected $fillable = ['code','name_en','name_lc','gender_id','email','province_id','district_id','local_level_id','ward_number','education_id','profession_id','gps_lat','gps_long','remarks'];
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
    public function gender()
    {
        return $this->belongsTo('App\Models\MstGender','gender_id','id');
    }

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
    public function education()
    {
        return $this->belongsTo('App\Models\MstEducationalLevel','education_id','id');
    }
    public function profession()
    {
        return $this->belongsTo('App\Models\MstProfession','profession_id','id');
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
