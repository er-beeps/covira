<?php

namespace App\Http\Controllers;

use DOMDocument;
use Goutte\Client;
use Illuminate\Http\Request;
use App\Models\NepalDataCovid;

class ScrapController extends Controller
{

    public function scrap(){
        $url="https://www.worldometers.info/coronavirus/";
        $html=file_get_contents($url);
        $dom=new \DOMDocument();
        @$dom->loadHTML($html);

        $tables=$dom->getElementsByTagName('table');
        $rows=$tables->item(0)->getElementsByTagName('tr');

        foreach ($rows as $row) {
            $cols=$row->getElementsByTagName('td');
            if(isset($cols->item(0)->nodeValue) && isset($cols->item(1)->nodeValue) && isset($cols->item(2)->nodeValue)){
               
                $title=trim($cols->item(1)->nodeValue);
                //get details only for nepal
                if($title === 'Nepal'){
                    $total_cases = trim($cols->item(2)->nodeValue);
                    $new_cases = trim($cols->item(3)->nodeValue);
                    $total_deaths = trim($cols->item(4)->nodeValue);
                    $new_deaths = trim($cols->item(5)->nodeValue);
                    $total_recovered = trim($cols->item(6)->nodeValue);
                    $active_cases = trim($cols->item(7)->nodeValue);

                    $data = [
                        'total_affected' => $total_cases,
                        'total_recovered' => $total_recovered,
                        'total_isolation' => $active_cases,
                        'total_death' => $total_deaths,
                        'new_cases' => $new_cases,
                        'new_recovered' => 0,
                        'new_death' => $new_deaths
                    ];
                    
                    NepalDataCovid::create($data);

                }

               
            }
        }
    }

 


    // public function scrap(){
    //     $client = new Client();
    //     $crawler = $client->request('GET', 'https://covid19.mohp.gov.np');
    //     $crawler->filter('#root > .ant-row > .ant-row > .ant-col> .ant-card >.ant-card-body > p');

    //     dd($crawler);
        
    //     // ->each(function ($node) {
    //     //     dd($node);
    //     //     dd($node->text());
    //     // });
    // }
}
