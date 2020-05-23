<script src="{{asset('js/gauge.js')}}"></script>

<style>
  #gauge{
    margin-left:15%;
  }
  .index{
    margin-left: 10%;
  }
  </style>

<div @include('crud::inc.field_wrapper_attributes')>
  <div class="row">

  <div class = "index">
    <table>
      <tr>
        <td><span  class="indicator" style= "width: 15px; height: 15px; margin:auto; display:inline-block; background-color:green"></td>
        <td>Very Low</td>
      </tr>
      <tr>
        <td><span class="indicator" style= "width: 15px; height: 15px; margin:auto; display:inline-block; background-color:#10b552"></td>
        <td>Low</td>
      </tr>
      <tr>
        <td><span class="indicator" style= "width: 15px; height: 15px; margin:auto; display:inline-block; background-color:yellow"></td>
        <td>Moderate</td>
      </tr>
      <tr>
        <td><span class="indicator" style= "width: 15px; height: 15px; margin:auto; display:inline-block; background-color:red"></td>
        <td>High</td>
      </tr>
      <tr>
        <td><span class="indicator" style= "width: 15px; height: 15px; margin:auto; display:inline-block; background-color:darkred"></td>
        <td>Very High</td>
      </tr>
    </table>
  </div>

    <canvas id="gauge"></canvas>
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
          length: 0.7,
          strokeWidth: 0.035,
          iconScale: 1.0
        },

        // static labels
        staticLabels: {
          font: "10px sans-serif",
          labels: [0, 20, 40, 60, 80, 100],
          fractionDigits: 0
        },

        // static zones
        staticZones: [
          {strokeStyle: "green", min: 0, max: 20},
          {strokeStyle: "#10b552", min: 20, max: 40},
          {strokeStyle: "yellow", min: 40, max: 60},
          {strokeStyle: "red", min: 60, max: 80},
          {strokeStyle: "darkred", min: 80, max: 100}
        ],

        highDpiSupport: true,
        angle: 0,


    };

var target = document.getElementById('gauge');
var gauge = new Gauge(target).setOptions(opts);
gauge.maxValue = 100;
gauge.setMinValue(0);
gauge.set(40);

</script>
</div>
