
@php 
request()->session()->put('key',1);
$province = request()->session()->get('province');
$district = request()->session()->get('district');
$locallevel = request()->session()->get('local_level_name');
$rtr = request()->session()->get('rtr');
@endphp



<script src="{{asset('js/gauge.js')}}"></script>

<style>
   #regional_risk_viewer{
        border-radius:25px;
        margin-bottom:8%;
        margin-left:5%;
        max-width:90%;
        max-height:90%;
    }

    .result-card{
        border-radius: 20px;
        margin:15px;
    }
    .header-card{
        border-radius: 20px;
        margin:15px;
    }
  
  #rr_gauge_view{
    height:80px;
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
<div id = "regional_risk_viewer">
        <div class="row">
            <div class="card header-card" style="background-color: #bafdd0; background-size:cover">
                <div class="card-header" style="font-size:16px;"><center><b>{{ $province }} - {{ $district }} - {{ $locallevel }} </b></center></div>
            </div>
        </div>

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
    <div class="col-xs-12 col-xs-8">
        <div class="card result-card" style="background-color: #bafdd0; background-size:cover">
            <div class="card-header heading"><span style="font-size:16px;"><center><b>{{trans('Regional Transmission Risk')}} </br>(तपाईको पालिकामा कोरोना सर्ने जोखिम)</b></center></span></div>
            <div class="card-body">
            <center><canvas id="rr_gauge_view"></canvas></center>                
            </div>
        </div>
    </div>    
</div>
</div>
  

  <script type="text/javascript">
    var opts = {
    // color configs
        colorStart: "#6fadcf",
        colorStop: void 0,
        gradientType: 0,
        strokeColor: "#e0e0e0",
        generateGradient: true,
        percentColors: [[0.0, "#a9d70b" ], [0.50, "#f9c802"], [1.0, "#ff0000"]],

        // customize pointer
        pointer: {
          length: 0.75,
          strokeWidth: 0.05,
          iconScale: 1.0
        },

        // static labels
        // staticLabels: {
        //   font: "10px sans-serif",
        //   labels: [0, 20, 40, 60, 80, 100],
        //   fractionDigits: 0
        // },

        // static zones
        staticZones: [
          {strokeStyle: "green", min: 0, max: 20},
          {strokeStyle: "#10b552", min: 20, max: 40},
          {strokeStyle: "yellow", min: 40, max: 60},
          {strokeStyle: "orange", min: 60, max: 80},
          {strokeStyle: "#e80000", min: 80, max: 100}
        ],

        highDpiSupport: true,
        angle: 0,


    };

var target = document.getElementById('rr_gauge_view');
var rr_gauge_view = new Gauge(target).setOptions(opts);
rr_gauge_view.maxValue = 100;
rr_gauge_view.setMinValue(0);

var rr_value =  '<?php echo $rtr ?>';
rr_gauge_view.set(rr_value);
</script>


