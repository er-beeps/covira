<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;

class ScrapController extends Controller
{
    public function startFetchingData(){
        $url="https://covid19.mohp.gov.np/";
        $html=file_get_contents($url);
        $dom=new \DOMDocument();
        @$dom->loadHTML($html);

        $content_node=$dom->getElementById("root");

        $div_row_class_nodes=$this->getElementsByClass($content_node, 'div', 'ant-card-body');
    
        dd($div_row_class_nodes);
        $datas=$dom->getElementsByClassName('ant-row');
        dd($datas);
        DB::delete('delete from news');
        foreach ($rows as $row) {
            $cols=$row->getElementsByTagName('td');
            if(isset($cols->item(0)->nodeValue) && isset($cols->item(1)->nodeValue) &&
            isset($cols->item(2)->nodeValue)){
                $sn=$cols->item(0)->nodeValue;
                $title=trim($cols->item(1)->nodeValue);
                $date=trim($cols->item(2)->nodeValue);
                $url =trim($cols->item(1)->childNodes[1]->getAttribute('href'));
                DB::insert("insert into news(sn,title,date_bs,url) values ('$sn','$title','$date','$url')");
            }
        }

    }

    public function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes=array();

        dd($parentNode,$tagName,$className);
    
        $childNodeList = $parentNode->getElementsByTagName($tagName);
        dd($childNodeList);
      
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[]=$temp;
            }
        }
    
        return $nodes;
    }
}
