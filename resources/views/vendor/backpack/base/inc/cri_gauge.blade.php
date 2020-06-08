<!-- <script src="{{asset('js/gauge.js')}}"></script> -->

<style>

  #cri_gauge_view
  {
    height:80px;
  }

  </style>

    <canvas id="cri_gauge_view"></canvas>

@php
if(!backpack_user()){
  $responseId = request()->session()->get('response_id');
  $data = \App\Models\Response::where('id',$responseId)->get();
  $cri = $data[0]->covid_risk_index;
}else{
  $data = \App\Models\Response::where('user_id',backpack_user()->id)->get();
  $cri = $data[0]->covid_risk_index;
}
@endphp

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

var target = document.getElementById('cri_gauge_view');
var cri_gauge_view = new Gauge(target).setOptions(opts);
cri_gauge_view.maxValue = 100;
cri_gauge_view.setMinValue(0);

var cri_value =  '<?php echo $cri ?>';
    if(cri_value >= 0 && cri_value < 6){
      cri_val = 0+cri_value*3.333333333;      
    }else if(cri_value > 6 && cri_value <= 15){
      cri_val = 20+(cri_value-6)*2.2222222;
    }else if(cri_value > 15 && cri_value <= 28){
      cri_val = 40+(cri_value-15)*1.53846;
    }else if(cri_value > 28 && cri_value <= 48){
      cri_val = 60+(cri_value-28);  
    }else if(cri_value > 48){
      cri_val = 80+(cri_value-48)*0.38462;   
    }
cri_gauge_view.set(cri_val);
</script>

