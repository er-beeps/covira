<body>
<div id = "result_viewer">
<script src="{{asset('js/gauge.js')}}"></script>

@php
$url = url('/');
$image_path = $url.'/img/result_view.png';
$responseId = request()->session()->get('response_id');
$country_exists = App\Models\Response::where('id',$responseId)->pluck('country_id')->first();
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
                        <div class="card-header"><span class ="heading"><b>{{trans('COVID Risk Index')}}<br> (कोरोनाको जोखिम स्तर) </b></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.cri_gauge'))
                        </div>
                    </div>
                </div>

                <div class="col-xs-5 col-xs-3">
                    <div class="card  result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header heading"><span class ="heading"><b>{{trans('Probability of COVID Infection')}}</br>(कोरोना सर्ने सम्भावना)</b></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.pci_gauge'))
                        </div>
                    </div>
                </div>
                @if($country_exists)
                {{-- do nothing --}}
                @else
                <div class="col-xs-5 col-xs-3">
                    <div class="card  result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header heading"><span class ="heading"><b>{{trans('Regional Transmission Risk')}} </br>(तपाईको पालिकामा कोरोना सर्ने सम्भावना)</b></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.rtr_gauge'))
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <br>

            <div class="row" style="margin-bottom:20px; margin-left:auto;">
                <div class="content-index col-md-12 col-md-8 col-md-6 col-md-4">
                    <span style="font-weight:bold"> Legend : </span>
                    <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:green;"><i<span>Very Low</span></button>
                    <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:#10b552;"><i<span>Low</span></button>
                    <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:yellow;"><i<span>Moderate</span></button>
                    <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:orange;"><i<span>High</span></button>
                    <button type="button" class="btn btn-sm btn-secondary legend-btn" style="background-color:red;"><i<span>Very High</span></button>
                </div>        
            </div>

            <br>
            <div class="row">
                <div class="col-md-12 col-md-8 col-md-4 social-share">
                    <div class="fb-share-button" data-href="https://covira.info" data-layout="button" data-size="large">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fcovira.info%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
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
      max-width:90%;
      max-height:90%;
  }
  .heading{
      font-size:13px;
      max-width:100%;
  }
  .social-share{
      text-align:center;
  }
  .addthis_inline_share_toolbox{
      display:inline-block;
  }
  .result-card{
    border-radius: 20px;
    margin:15px;
  }
  </style>
  </body>
