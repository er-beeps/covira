<?php

namespace App\Base\Helpers;
use App\Base\Helpers\NepaliCalendar;
use Carbon\Carbon;


class GetNepaliServerDate
{
    function splitDate()
    {
     $currentDate = Carbon::now()->toDateString();

     $currentDate = explode('-', $currentDate);

     $year  = $currentDate[0];
     $month = $currentDate[1];
     $date   = $currentDate[2];

     $split_date =[
         'year' => $year,
         'month' =>$month,
         'date' => $date ]; 

     return $split_date;       
    }

    function getNepaliDate(){
        $dateHelper = new GetNepaliServerDate();

        $n_year = $dateHelper->splitDate()['year'];
        $n_month = $dateHelper->splitDate()['month'];
        $n_date = $dateHelper->splitDate()['date'];

        $cal = new NepaliCalendar();

        $nepali_Date = $cal->eng_to_nep($n_year, $n_month, $n_date);

        $nepaliDate =implode("-", $nepali_Date);
   
        return $nepaliDate; 
    }
}