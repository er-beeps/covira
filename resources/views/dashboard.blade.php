@extends(backpack_view('layouts.top_left'))

@php
    $lang = App::getLocale();

    function convertToNepaliNumber($input)
    {
        $standard_numsets = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", '-', '/');
        $devanagari_numsets = array("०", "१", "२", "३", "४", "५", "६", "७", "८", "९", '-', '-');

        return str_replace($standard_numsets, $devanagari_numsets, $input);
    }
@endphp

@section('content')
<script src="{{asset('js/gauge.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/gismap/css/gismap.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/mapview.css') }}" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
 <link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.Default.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/Control.FullScreen.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/leaflet.css') }}" />

<style>

#assess-btn{
    color:blue;
    font-size:16px;
    animation:blinkingbtn 2s infinite;
}
@keyframes blinkingbtn{
    0%{     color: transparent;    }
    25%{     color: green;    }
    50%{    color: blue; }
    75%{    color:red;  }
    100%{   color: darkred;    }
}

.legend-btn{
    margin:0px 5px;
    align:center;
    color:black;
}
.about-card{
    margin-left:2%;
    margin-right:2%;
    border-radius:20px;

}
.about-content{
        font-size:15px;
        color: red;
        animation:blinkingText 5s infinite;
    }
    @keyframes blinkingText{
    0%{     color: transparent;    }
    25%{     color: green;    }
    50%{    color: blue; }
    75%{    color:red;  }
    100%{   color: darkred;    }
}
#more {
    display: none;
}
</style>

<div class ="row">
    <div class="col-md-2">
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightblue; background-size:cover;">
                <div class="card-header">
                @if(backpack_user())
                    <center><a href="{{backpack_url('response/create')}}" id="assess-btn"><b>{{trans('dashboard.assessrisk')}}</b></a><center>
                @else
                    <center><a href="/public/fill_response/create" id="assess-btn"><b>{{trans('dashboard.assessrisk')}}</b></a><center>
                @endif    
                </div>
            </div>
        </div>
        @if(backpack_user() && backpack_user()->hasrole('normal'))
            @php
            $id = \App\Models\Response::where('user_id',backpack_user()->id)->pluck('id')->first();
            @endphp
            <div class="row">
                <div class="card col-xs-12 side-card" style="background-color: #bafdd0; background-size:cover">
                    <div class="card-header" style="font-size:13px;"><center><b>{{trans('dashboard.covidriskindex')}}</b></center></div>
                    <div class="card-body">
                    @if(isset($id))
                            <center>@include(backpack_view('inc.cri_gauge'))</center>
                    @else
                    <span style="color:red;"><b>{{trans('dashboard.accessriskwarning')}}</b></span>
                    @endif        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-xs-12 side-card" style="background-color: bisque; background-size:cover">
                    <div class="card-header" style="font-size:13px;"><b>{{trans('dashboard.covidchance')}}</b></div>
                    <div class="card-body">
                    @if(isset($id))
                    <center>@include(backpack_view('inc.pci_gauge'))</center>
                    @else
                        <span style="color:red;"><b>{{trans('dashboard.covidchance')}}</b></span>
                    @endif  
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-md-12 side-card" style="background-color: lightgreen; background-size:cover;">
                    <div class="card-header">
                        <center><a href="{{backpack_url('/response'.'/'.$id.'/edit')}}" style="color:blue; font-size:15px;"><b>{{trans('dashboard.survey')}}</b></a><center>
                    </div>
                </div>
            </div>
        @elseif(!backpack_user())
            <div class="row">
                <div class="card col-md-12 side-card" style="background-color: lightgray; background-size:cover;">
                    <div class="card-header"><center><b>
                        <a data-fancybox data-type="ajax" href="/response/view_result" id = "result_view" style="color:darkblue; font-size:15px;">{{ trans('dashboard.view_result') }}</a>  
                        <a data-fancybox data-type="ajax" href="/response/view_result_proceed" id = "result_view_proceed_btn"></a>  
                        <a data-fancybox data-type="ajax" href="/response/view_regional_risk" id = "regional_risk_btn"></a>  
                        </b></center
                    ></div>
                </div>
            </div>   
        @endif
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: #bafdd0; background-size:cover">
                <div class="card-header"><center><b style="font-size:17px;">{{trans('dashboard.covidnepal')}}<br>{{trans('dashboard.total_data')}} </b><center></div>
                <div class="card-body ">
                        <table class="nepal_data_table" style="margin-left:-20px;">
                            <tr>
                                <td width="150%" class="title font-weight-bold"><i class="fa fa-dot-circle-o"> &nbsp;</i>{{trans('dashboard.total_pcr')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_swab_test ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td width="150%" class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:orange;"> &nbsp;</i>{{trans('dashboard.infected')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_affected ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:green;"> &nbsp;</i>{{trans('dashboard.recovered')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_recovered ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:gray;"> &nbsp;</i>{{trans('dashboard.isolation')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_isolation ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:red;"> &nbsp;</i>{{trans('dashboard.deaths')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_death ?? '0'}}</td>
                            </tr>
                          
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:blue;"> &nbsp;</i>{{trans('dashboard.quarantine')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_quarantine ?? '0'}}</td>
                            </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <center><b>{{ trans('dashboard.source')}} <a target="_blank" href="https://covid19.mohp.gov.np/">MOHP</a></b></center>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-8">
        @include(backpack_view('inc.search_filter'))
    
          <div class="row">
            <div class="col-md-12">
                <div class="card bg-light map-card">
                    <div class="card-header map-card-header" style="background-color: lightgray">
                        <div class = "map-tab">
                            <ul class="nav nav-tabs">
                                {{-- <li class="for_map">
                                    <a href="#open_street" data-toggle="tab" class="streets">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Open Streets Map">
                                            <img class="" src="/css/images/open_street_map1.ico" width="30px">
                                        </div>
                                    </a>
                                </li> --}}
                                <li class="for_map">
                                    <a href="#google_map" data-toggle="tab" class="active streets">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Google Map">
                                            <img class="" src="/css/images/google-map.png" width="30px">
                                        </div>
                                    </a>
                                </li>
                                <li class="for_chart">
                                    <a data-fancybox data-type="ajax" href="/response/fetchimages?id=1"  class="btn btn-secondary btn-sm btn-map" style="border:1px solid gray;">{{ trans('dashboard.socioeconomic_risk') }}</a>
                                </li>
                                <li class="for_chart">
                                    <a data-fancybox data-type="ajax" href="/response/fetchimages?id=2"  class="btn btn-secondary btn-sm btn-map" style="border:1px solid gray;">{{ trans('dashboard.publichealth_risk') }}</a>
                                </li>
                                <li class="for_chart">
                                    <a data-fancybox data-type="ajax" href="/response/fetchimages?id=3"  class="btn btn-secondary btn-sm btn-map" style="border:1px solid gray;">{{ trans('dashboard.food_productivity_map') }}</a>
                                </li>
                                <li class="for_chart">
                                    <a data-fancybox data-type="ajax" href="/response/fetchimages?id=4"  class="btn btn-secondary btn-sm btn-map" style="border:1px solid gray;">{{ trans('dashboard.transmission_risk') }}</a>
                                </li>
                                <li class="for_chart">
                                    <a data-fancybox data-type="ajax" href="/response/fetchimages?id=5"  class="btn btn-secondary btn-sm btn-map" style="border:1px solid gray;">{{ trans('dashboard.overall_risk') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" id="open_street">
                            <div class="map-body">
                                <div id="map"></div>
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>
                            </div>
                        </div>

                        <div class="active tab-pane" id="google_map">
                            <div class="map-body">
                                <div id="map1"></div> 
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>   
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row" style="margin-bottom:20px; margin-left:auto;">
            <div class="col-md-7 col-md-6 col-md-4 content-index">
                <span style="font-weight:bold"> Legend : </span>
                <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:green;"><span>{{ trans('dashboard.verylow')}}</span></button>
                <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:#10b552;"><span>{{ trans('dashboard.low')}}</span></button>
                <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:yellow;"><span>{{ trans('dashboard.moderate')}}</span></button>
                <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:orange;"><span>{{ trans('dashboard.high')}}</span></button>
                <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:red;"><span>{{ trans('dashboard.veryhigh')}}</span></button>
            </div>        
            <div class="col-md-5 content-footer">
                <button type="button" onclick="incrementLike(this)" class="btn btn-sm btn-outline-secondary"><i
                        class="fa fa-thumbs-o-up text-success"></i> <span id="like-counter"
                    class="badge" style="color:black; font-size:13px;">Likes {{$likes}}</span></button>
                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                    class="fa fa-eye text-primary"></i><span
                    class="badge"style="color:black; font-size:13px;">Views {{$views}}</span>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="share-btn"><i
                    class="fa fa-share text-primary"></i><span
                    class="badge"style="color:black; font-size:13px;">Share</span>
                </button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="card col-xs-12 about-card" style="background-color: white; background-size:cover;">
                <div class="card-header about-content">
                कोभिरा (COVID-19 Vulnerability Risk Analysis), बिभिन्न देशका डाटाहरुको अध्ययन अनुसन्धानमा आधारित जोखिम मुल्यांकन गर्ने बिधि हो। कम जोखिम हुनु भनेको जोखिम नहुनु होइन। अनुसन्धानको बिस्तृत बिबरण तलको लिंकमा उपलब्ध छ। <br> 
                <b>Citation: <a target="_blank" href = "https://www.medrxiv.org/content/10.1101/2020.07.11.20151464v1?fbclid=IwAR0a-vFpKoGwr8VIquw3EhJ21BwWE10uF1esEhBdv4eBYke0ysQWPGxJgr0">Multidisciplinary Approach to COVID-19 Risk Communication: A Framework and Tool for Individual and Regional Risk Assessment.</a></b>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col-xs-10 " style="background-color: white; background-size:cover;">
                <div class="card-header">
                <p>
                <center><b>How to protect yourself and others?</b></center><br>
                <center><b>Stay at home and stay safe</b></center><br>

                    <b>1.	What is COVID-19 ?</b> </br>
                    A virus linked to the family of severe acute respiratory syndrome coronavirus 2 (SARS-CoV-2) was identified as the cause of a disease outbreak that began in China in 2019. The disease is called coronavirus disease 2019 (COVID-19).</br></br>

                    <b>2.	How does COVID-19 spread?</b></br>
                    Several studies have shown that it spreads from person to person among those in close contact (within about 6 feet, or 2 meters).<span id="dots">...</span><span id="more"> The virus spreads by respiratory droplets released when someone infected with the virus coughs, sneezes or talks.</br></br>
                    
                    <b>3.  What are the symptoms of COVID-19?</b> </br>
                    COVID-19 symptoms can be very mild to severe. Sometime it is asymptomatic. The most common symptoms are fever, cough and tiredness. Other symptoms may include shortness of breath, muscle aches, chills, sore throat, headache, chest pain, and loss of taste or smell etc. Other less common symptoms have also been reported. Symptoms may appear two to 14 days after exposure.</br></br>

                    <b>4. Can COVID-19 be prevented or treated?</b> </br>
                    No vaccine is available yet for the coronavirus disease 2019 (COVID-19). No medication is recommended to treat COVID-19. Treatment is directed at relieving symptoms.</br></br>

                    <b>5. What can I do to avoid becoming ill?</b> </br>
                    <ul>
                    <li>	Wash your hands often with soap and water for at least 20 seconds, or use an alcohol-based hand sanitizer that contains at least 60% alcohol.</li>
                    <li>	Wear a surgical/cloth face mask in public areas</li>
                    <li>	Keep a distance of about 6 feet, or 2 meters with anyone (who is sick or has symptoms).</li>
                    <li>	Cover your mouth and nose with your elbow or a tissue when you cough or sneeze. Throw away the used tissue.</li>
                    <li>	Avoid large events and mass gatherings.</li>
                    <li>	Avoid touching your eyes, nose and mouth.</li>
                    <li>	Clean and disinfect surfaces you often touch on a daily basis.</li>
                    </ul>

                    If you have a chronic medical condition and may have a higher risk of serious illness, check with your doctor about other ways to protect yourself.</br></br>

                    <b>6. Should I wear a mask?</b> </br>
                    We highly recommend wearing surgical/cloth mask in public places, such as the grocery store, where it's difficult to avoid close contact with others. It's especially suggested in areas with ongoing community spread. This updated advice is based on data showing that people with COVID-19 can transmit the virus before they realize they have it. Using masks in public may help reduce the spread from people who don't have symptoms. Non-medical cloth masks are recommended for the public. 
                    Surgical masks and N-95 respirators are in short supply and should be reserved for health care providers.</br></br>

                    <b>7. What can I do if I am or may be ill with COVID-19?</b> </br>
                    COVID-19 symptoms include fever, coughing and shortness of breath, plus additional ones mentioned above. Keep track of your symptoms, which may appear two to 14 days after exposure, and call to seek medical attention if your symptoms worsen, such as difficulty breathing. If you think you may have been exposed to COVID-19, contact your health care provider immediately.
                    Take the following precautions to avoid spreading the illness:
                    <ul>
                    <li>	Stay home from work, school and public areas, except to get medical care.</li>
                    <li>	Avoid taking public transportation if possible.</li>
                    <li>	Wear a mask around other people.</li>
                    <li>	Isolate yourself as much as possible from others in your home.</li>
                    <li>	Use a separate bedroom and bathroom if possible.</li>
                    <li>	Avoid sharing dishes, glasses, bedding and other household items.</li>
                    </ul>

                    <b>8. Understanding the risks</b> </br>
                    It’s very important to understand that even when people appear not to have symptoms of coronavirus (COVID-19), they may still be carrying the virus.  Where you’re meeting people who aren’t from your household, your risk of catching coronavirus can increase depending on the situation.  
                    Science Hub assesses the risk (high to low) through COVID-19 risk assessment and communication tool (COVIRA).  You can assess your and your loved ones risk; and should take these risks into account when you are thinking about visiting or gathering with other people, in particular the time limits where you may be at a higher risk of catching COVID-19 when spending time with someone indoors. 
                    You should also consider the greater risks posed to those who are classified as vulnerable and very vulnerable. When meeting people from outside your household, that is, people you don’t currently live with, you should continue to follow the national guidance, and practice good respiratory hygiene.
                    Who is at a higher risk? 
                    Early information of several countries show that older adults, people who live in a nursing home or long-term care facility, and individuals of any age with the conditions below are at higher risk of getting very sick from COVID-19:
                    <ul>
                    <li>	Have serious underlying medical conditions, particularly if not well controlled, such as heart, lung or liver disease; diabetes; moderate to severe asthma; severe obesity; and chronic kidney disease undergoing dialysis.</li>
                    <li>	Have a weakened immune system, including those undergoing cancer treatment, smoking and having other immune compromised conditions.</li>
                    </ul>
                    If you are at higher risk for serious illness from COVID-19, it is critical for you too:
                    </p> 
                    <p>
                    <span>-----------------------------------------------------------------------------------------------------------</span></br>
                    <b>Sources:</b><br>
                    <ol>
                        <li>	Ministry of Health and Population, Government of Nepal. <a target="_blank" href="https://heoc.mohp.gov.np/update-on-novel-corona-virus-covid-19/">https://heoc.mohp.gov.np/update-on-novel-corona-virus-covid-19/</a> </li>
                        <li>	World Health Organization. <a target="_blank" href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019"> https://www.who.int/emergencies/diseases/novel-coronavirus-2019</a>. </li>
                        <li>	Central for disease control and prevention. <a target="_blank" href= "https://www.cdc.gov/coronavirus/2019-ncov/prevent-getting-sick/prevention.html"> https://www.cdc.gov/coronavirus/2019-ncov/prevent-getting-sick/prevention.html</a> </li>
                        <li>    American Red Cross. <a target="_blank" href="https://www.redcross.org/about-us/news-and-events/news/2020/coronavirus-safety-and-readiness-tips-for-you.html"> https://www.redcross.org/about-us/news-and-events/news/2020/coronavirus-safety-and-readiness-tips-for-you.html</a> </li>
                    </ol>
                    </p></span>
                    <button onclick="showMore()" id="show-more">Read more</button>
                </div>
            </div>
        </div>


    </div>

    <div class="col-md-2">
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: #bafdd0; background-size:cover">
                <div class="card-header"><center><b style="font-size:17px;">{{trans('dashboard.today_update')}}</b><center></div>
                <div class="card-body ">
                        <table class="nepal_data_table" style="margin-left:-20px; font-size:14px;">
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:orange;"> &nbsp;</i>{{trans('dashboard.today_pcr')}}</td>
                                <td class="data"> {{$nepal_covid_data->new_pcr ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td width="150%" class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:blue;"> &nbsp;</i>{{trans('dashboard.today_newcase')}}</td>
                                <td class="data"> {{$nepal_covid_data->new_cases ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:green;"> &nbsp;</i>{{trans('dashboard.today_recovered')}}</td>
                                <td class="data"> {{$nepal_covid_data->new_recovered ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title font-weight-bold"><i class="fa fa-dot-circle-o" style="color:red;"> &nbsp;</i>{{trans('dashboard.today_death')}}</td>
                                <td class="data"> {{$nepal_covid_data->new_death ?? '0'}}</td>
                            </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <center><b>{{ trans('dashboard.source')}} <a target="_blank" href="https://covid19.mohp.gov.np/">MOHP</a></b></center>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightgreen; background-size:cover;">
                <div class="card-header">
                    <center><a target="_blank" href="https://www.worldometers.info/coronavirus/" style="color:blue; font-size:15px;"><b>{{trans('dashboard.worldupdates')}}</b></a><center>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color:bisque; background-size:cover;">
                <div class="card-header">
                    <center><a target="_blank" href="https://heoc.mohp.gov.np/update-on-novel-corona-virus-covid-19/" style="color:blue; font-size:15px;"><b>{{trans('dashboard.covid_guidelines')}}</b></a><center>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightgray; background-size:cover;">
                <div class="card-header">
                    <center><a target="_blank" href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019?gclid=CjwKCAjw5cL2BRASEiwAENqAPngAvVQESLDpig3crKIIaGLOmmAflAkyRa8lrvBPUAtaKIX-pbwOKhoCDWwQAvD_BwE" style="color:darkblue; font-size:15px;"><b>{{trans('dashboard.covid_updates')}}</b></a><center>
                </div>
            </div>
        </div>
    </div>       
</div>

    
<script src="{{asset('js/dependentdropdown.js') }}"></script>
<script src="{{ asset('/gismap/js/oms.min.js') }}"></script>
<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>

<script src="{{ asset('/gismap/js/leaflet.markercluster-src.js') }}"></script>
 <script src="{{ asset('/gismap/js/Control.FullScreen.js') }}"></script>
<script src="{{ asset('/gismap/js/leafletopenstreet.js') }}"></script>
 <script src="{{ asset('/gismap/js/googlemap.js') }}"></script>
<script src="{{ asset('/gismap/js/markerclusterer_compiled.js') }}"></script>
<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoEoSKYFDXovqwCwCHIhAYGFsnrUW09Oo&callback=initMap"></script>

@php
$session = request()->session();
$responseId = request()->session()->get('response_id');
$key = request()->session()->get('key');
$is_calculated = request()->session()->get('is_calculated');
$process_step_id = \App\Models\Response::whereId($responseId)->pluck('process_step_id')->first();
@endphp

@section('after_scripts')
<script>
$(document).ready(function(){
    let lang = "<?php echo App::getLocale() ?>";
    sessionStorage.setItem("lang", lang);

    var processStepId = '<?php echo $process_step_id ?>';
    var isCalculated = '<?php echo $is_calculated ?>';

    if(processStepId == 4){

        $('#result_view').trigger('click');
    }
    if(isCalculated === 'true' && processStepId != 4){
        $('#result_view_proceed_btn').trigger('click');
    }

    var key = '<?php echo $key ?>';
    
    if(key === '0'){
        $('#regional_risk_btn').trigger('click');
    }else{

    }

});
</script>

<script>
function incrementLike(button){
    var button = $(button);
    Url = '/dashboard/incrementlike';

    $.ajax({
        url:Url,
        method:"POST",
        success:function(res){
            console.log(res);
            if(res.message =='success'){
                var like = res.like_count;
                $('#like-counter').html('Likes '+like);
            }else{
            }
        }
    });
}
  var fbButton = document.getElementById('share-btn');
    fbButton.addEventListener('click', function() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fcovira.info%2F&amp;src=sdkpreparse',
        'facebook-share-dialog',
        'width=600,height=500'
    );
    return false;
});

function showMore() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("show-more");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}

</script>
@endsection

@endsection

