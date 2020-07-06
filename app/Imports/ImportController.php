<?php

namespace App\Imports;

use DB;
use Carbon\Carbon;
use App\Models\DtRiskTransmission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportController implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    
        return  new DtRiskTransmission([
            'code'=>$row['code'],
            'district_name'=>$row['district_name'],
            'gapa_napa'=>$row['gapa_napa'],
            'gapa_napa_type'=>$row['gapa_napa_type'],
            'lat'=>$row['lat'],
            'long'=>$row['long'],
            'ctr'=>$row['ctr'],
            'trs'=>$row['trs'],
            'date_ad'=>Carbon::now()->toDateString(),
            'date_bs'=>Carbon::now()->toDateString(),
        ]);
}
}
