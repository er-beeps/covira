<body>
<div id = "result_viewer">
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ed7de596973dba7"></script>

<script src="{{asset('js/gauge.js')}}"></script>

@php
$url = url('/');
$image_path = $url.'/img/result_view.png';
$responseId = request()->session()->get('response_id');
@endphp
    <div class="row">
        <div class="col-md-12 col-md-8 col-md-4 col-md-2">
            <div class ="row">
                <div class="col-md-12 col-md-8 col-md-4" style="text-align:center">
                    <h5><b>Risk Assessment Result !!</b></h5>
                </div>
            </div>

            <br>
            @if(isset($responseId) && $responseId != NULL)
            <div class="row">
                <div class="col-xs-5 col-xs-3">
                    <div class="card result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header"><span class ="heading"><b>{{trans('COVID Risk Index')}}</b></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.cri_gauge'))
                        </div>
                    </div>
                </div>

                <div class="col-xs-5 col-xs-3">
                    <div class="card  result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header heading"><span class ="heading"><b>{{trans('Probability of COVID Infection')}}</b></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.pci_gauge'))
                        </div>
                    </div>
                </div>

                <div class="col-xs-5 col-xs-3">
                    <div class="card  result-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header heading"><span class ="heading"><b>{{trans('Regional Transmission Risk')}}</b></span></div>
                        <div class="card-body">
                            @include(backpack_view('inc.rtr_gauge'))
                        </div>
                    </div>
                </div>
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
                    <!-- <div class="addthis_inline_share_toolbox"></div> -->

                    <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>

                    <!-- Your share button code -->
                    <div class="fb-share-button" 
                        data-href="http://127.0.0.1:8000" 
                        data-layout="button_count">
                    </div>
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
