<body>
<div id = "result_viewer">
<script src="{{asset('js/gauge.js')}}"></script>

@php
$url = url('/');
$image_path = $url.'/img/result_view.png';
$responseId = request()->session()->get('response_id');
$other_country = App\Models\Response::where('id',$responseId)->pluck('is_other_country')->first();
@endphp
    <div class="row">
        <div class="col-md-12 col-md-8 col-md-4 col-md-2">
            <div class ="row">
                <div class="col-md-12 col-md-8 col-md-4" style="text-align:center">
                    <h5><b>Your COVID-19 Risk Assessment Result !!</b></h5>
                </div>
            </div>

            <br>
            @if(isset($responseId) && $responseId != NULL)
            <div class="row">
                <div class="col-xs-5 col-xs-3">
                    <div class="card result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-body">
                            <div class = "index"><center><b>Legend:</b></center>
                                <table id ="index">
                                <tr>
                                    <td><span class="indicator-box" style= "background-color:green"></td>
                                    <td><span class="indicator-label">Very Low</span></td>
                                </tr>
                                <tr>
                                    <td><span class="indicator-box" style= "background-color:#10b552"></td>
                                    <td><span class="indicator-label">Low</span></td>
                                </tr>
                                <tr>
                                    <td><span class="indicator-box" style= "background-color:yellow"></td>
                                    <td><span class="indicator-label">Moderate</span></td>
                                </tr>
                                <tr>
                                    <td><span class="indicator-box" style= "background-color:orange"></td>
                                    <td><span class="indicator-label">High</span></td>
                                </tr>
                                <tr>
                                    <td><span class="indicator-box" style= "background-color:#e80000"></td>
                                    <td><span class="indicator-label">Very High</span></td>
                                </tr>
                                </table>
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="col-xs-5 col-xs-3">
                    <div class="card result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header"><span class ="heading"><center><b>{{trans('COVID Risk Index')}}<br> (कोरोनाको जोखिम स्तर) </b></center></span></div>
                        <div class="card-body">
                            <center>@include(backpack_view('inc.cri_gauge'))</center>
                        </div>
                    </div>
                </div>

                <div class="col-xs-5 col-xs-3">
                    <div class="card  result-card" style="background-color: #bafdd0; background-size:cover">
                    @if($other_country)
                        <div class="card-header heading"><span class ="heading" style="font-size:16px;"><center><b>{{trans('Your exposure level')}}</br> &nbsp</b></center></span></div>
                    @else
                        <div class="card-header heading"><span class ="heading"><center><b>{{trans('Probability of COVID Infection')}}</br>(तपाईंलाई कोरोना सर्ने जोखिम)</b></center></span></div>
                    @endif    
                        <div class="card-body">
                            <center>@include(backpack_view('inc.pci_gauge'))</center>
                        </div>
                    </div>
                </div>
                @if($other_country)
                {{-- do nothing --}}
                @else
                <div class="col-xs-5 col-xs-3">
                    <div class="card  result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header heading"><span class ="heading"><center><b>{{trans('Regional Transmission Risk')}} </br>(तपाईको पालिकामा कोरोना सर्ने जोखिम)</b></center></span></div>
                        <div class="card-body">
                            <center>@include(backpack_view('inc.rtr_gauge'))</center>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @if($other_country)
            @else
            <div class="row">
                <div class="personal-message col-xs-12 col-xs-8">
                    <div class="card result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header heading"><span style="color:blue; font-size:16px;"><center><b>सुझाव</b></center></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.personal_message'))                 
                        </div>
                    </div>
                </div>    
            </div>
             @endif

            <br>
            <div class="row">
                <div class="col-md-12 col-md-8 col-md-4 social-share">
                <div id="fb-share-button">
                    <svg viewBox="0 0 12 12" preserveAspectRatio="xMidYMid meet">
                        <path class="svg-icon-path" d="M9.1,0.1V2H8C7.6,2,7.3,2.1,7.1,2.3C7,2.4,6.9,2.7,6.9,3v1.4H9L8.8,6.5H6.9V12H4.7V6.5H2.9V4.4h1.8V2.8 c0-0.9,0.3-1.6,0.7-2.1C6,0.2,6.6,0,7.5,0C8.2,0,8.7,0,9.1,0.1z"></path>
                    </svg>
                    <span>Share</span>
                </div>

                    <!-- <div id="fb-share-button" data-href="https://covira.info" data-layout="button" data-size="large">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fcovira.info%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div> -->
                </div>
            </div>
            @else
            <span style="color:red; font-weight:bold;">Please assess your risk first !!<span>
            @endif 

        </div>
    </div>
</div>

<style>
    #result_viewer{
        border-radius:25px;
        margin-bottom:8%;
        margin-left:5%;
        max-width:75%;
        max-height:90%;
    }
    .heading{
        font-size:13px;
        max-width:100%; 
    }
    .social-share{
        text-align:center;
    }
  
    .result-card{
        border-radius: 20px;
        margin:15px;
    }

    #fb-share-button{
        background: #385898;
        border-radius: 5px;
        font-weight: 600;
        padding: 5px 8px;
        display: inline-block;
        position: static;
    }
    #fb-share-button:hover {
    cursor: pointer;
    background: #213A6F
    }
    
    #fb-share-button svg {
        width: 18px;
        fill: white;
        vertical-align: middle;
        border-radius: 2px
    }

    #fb-share-button span {
        vertical-align: middle;
        color: white;
        font-size: 14px;
        padding: 0 3px
    }
 
  span.indicator-box {
    margin-bottom:0px;
    margin-right:10px;
    margin-top:5px;
  }
  .indicator-box{
    width:17px;
    height:17px;
    margin:auto;
    display: inline-block;
    border:1px solid gray;
    border-radius: 3px;
  }
  .indicator-label{
    font-size: 13px;
    font-weight:bold;
    margin-top:-20px;
  }
  </style>

  <script>
  var fbButton = document.getElementById('fb-share-button');
    fbButton.addEventListener('click', function() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fcovira.info%2F&amp;src=sdkpreparse',
        'facebook-share-dialog',
        'width=600,height=500'
    );
    return false;
});
  </script>
  </body>
