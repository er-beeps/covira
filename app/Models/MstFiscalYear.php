<?php

namespace App\Models;

use App\Base\BaseModel;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class MstFiscalYear extends BaseModel
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mst_fiscal_year';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['code','from_date_bs','from_date_ad','to_date_bs','to_date_ad','remarks','created_by','updated_by'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
  
    public function convertToNepaliNumber($input)
    {
        $standard_numsets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", '-','/');
        $devanagari_numsets = array("०", "१", "२", "३", "४", "५", "६", "७", "८", "९", '-','-');

        return str_replace($standard_numsets, $devanagari_numsets, $input);
    }

    public function getStartedDateAttribute() {
        $fromDateBs = $this->convertToNepaliNumber($this->from_date_bs);

        return $fromDateBs."\n".$this->from_date_ad;
    }
    public function getClosedDateAttribute() {
        $toDateBs = $this->convertToNepaliNumber($this->to_date_bs);

        return $toDateBs."\n".$this->to_date_ad;
    }

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
