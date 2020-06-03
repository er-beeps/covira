<?php

namespace App\Models;

use App\Base\BaseModel;
use App\Base\DataAccessPermission;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Response extends BaseModel
{
    use CrudTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $dataAccessPermission = DataAccessPermission::ShowClientWiseDataOnly;

    protected $table = 'response';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id','created_by','updated_by'];
    protected $fillable = ['code','user_id','name_en','name_lc','age','gender_id','email','is_other_country','country_id','city','province_id','district_id','local_level_id','ward_number','education_id','profession_id','gps_lat','gps_long',
    'process_step_id','neighbour_proximity','community_situation','confirmed_case','inbound_foreign_travel','community_population','hospital_proximity','corona_centre_proximity',
    'health_facility','market_proximity','food_stock','agri_producer_seller','product_selling_price','commodity_availability','commodity_price_difference','job_status','economic_impact','sustainability_duration','remarks'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
     public function convertToNepaliNumber($input)
    {
        $standard_numsets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", '-', '/');
        $devanagari_numsets = array("०", "१", "२", "३", "४", "५", "६", "७", "८", "९", '-', '-');

        return str_replace($standard_numsets, $devanagari_numsets, $input);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function gender()
    {
        return $this->belongsTo('App\Models\MstGender','gender_id','id');
    }
    public function country()
    {
        return $this->belongsTo('App\Models\Country','country_id','id');
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

    //pivot saving
    public function personal_travel()
    {
        return $this->belongsToMany('App\Models\PrActivity','respondent_data','response_id','activity_id');
    }

    public function safety_measure()
    {
        return $this->belongsToMany('App\Models\PrActivity','respondent_data','response_id','activity_id');
    }

    public function habits()
    {
        return $this->belongsToMany('App\Models\PrActivity','respondent_data','response_id','activity_id');
    }

    public function health_condition()
    {
        return $this->belongsToMany('App\Models\PrActivity','respondent_data','response_id','activity_id');
    }

    public function symptom()
    {
        return $this->belongsToMany('App\Models\PrActivity','respondent_data','response_id','activity_id');
    }

  
   
    //normal saving in own table
    public function neighbour_proximity()
    {
        return $this->belongsTo('App\Models\PrActivity','neighbour_proximity','id');
    }
    public function community_situation()
    {
        return $this->belongsTo('App\Models\PrActivity','community_situation','id');
    }
    public function confirmed_case()
    {
        return $this->belongsTo('App\Models\PrActivity','confirmed_case','id');
    }
    public function inbound_foreign_travel()
    {
        return $this->belongsTo('App\Models\PrActivity','inbound_foreign_travel','id');
    }
    public function community_population()
    {
        return $this->belongsTo('App\Models\PrActivity','community_population','id');
    }
    public function hospital_proximity()
    {
        return $this->belongsTo('App\Models\PrActivity','hospital_proximity','id');
    }
    public function corona_centre_proximity()
    {
        return $this->belongsTo('App\Models\PrActivity','corona_centre_proximity','id');
    }
    public function health_facility()
    {
        return $this->belongsTo('App\Models\PrActivity','health_facility','id');
    }
    public function market_proximity()
    {
        return $this->belongsTo('App\Models\PrActivity','market_proximity','id');
    }
    public function food_stock()
    {
        return $this->belongsTo('App\Models\PrActivity','food_stock','id');
    }
    public function agri_producer_seller()
    {
        return $this->belongsTo('App\Models\PrActivity','agri_producer_seller','id');
    }
    public function product_selling_price()
    {
        return $this->belongsTo('App\Models\PrActivity','product_selling_price','id');
    }
    public function commodity_availability()
    {
        return $this->belongsTo('App\Models\PrActivity','commodity_availability','id');
    }
    public function commodity_price_difference()
    {
        return $this->belongsTo('App\Models\PrActivity','commodity_price_difference','id');
    }
    public function job_status()
    {
        return $this->belongsTo('App\Models\PrActivity','job_status','id');
    }
    public function economic_impact()
    {
        return $this->belongsTo('App\Models\PrActivity','economic_impact','id');
    }
    public function sustainability_duration()
    {
        return $this->belongsTo('App\Models\PrActivity','sustainability_duration','id');
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
    public function province_district()
    {
        if(isset($this->province_id) && isset($this->district_id)){
            return $this->province->name_lc.'<br>'.$this->district->name_lc;
        }else{
            return ' - '.'<br>'.' - ';
        }
    }
    
    public function local_address()
    {
        if(isset($this->locallevel_id) && isset($this->ward_number)){
            return $this->locallevel->name_lc.'<br>'.$this->convertToNepaliNumber($this->ward_number);
        }else{
            return ' - '.'<br>'.' - ';
        }
    }
}
