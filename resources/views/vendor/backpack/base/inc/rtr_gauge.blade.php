<!-- <script src="{{asset('js/gauge.js')}}"></script> -->

<style>

  #rtr_gauge_view{
    height:80px;
  }

  </style>

    <canvas id="rtr_gauge_view"></canvas>



@php
if(!backpack_user()){
  $responseId = request()->session()->get('response_id');
  $data = \App\Models\Response::where('id',$responseId)->get();
  $local_level_code = $data[0]->locallevel->code;
  $rtr = DB::table('dt_risk_transmission')->where('code',$local_level_code)->pluck('ctr')->first();

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

var target = document.getElementById('rtr_gauge_view');
var rtr_gauge_view = new Gauge(target).setOptions(opts);
rtr_gauge_view.maxValue = 100;
rtr_gauge_view.setMinValue(0);

var rtr_value =  '<?php echo $rtr ?>';
rtr_gauge_view.set(rtr_value);
</script>

