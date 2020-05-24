<script src="{{asset('js/gauge.js')}}"></script>

<style>
    .pci_title{
    margin-left: 10%;
    text-align: center;
  }
  </style>

<div class="col-md-6">
    <div class="row">
      <span class="pci_title">Probability of Covid Infection</span>
    </div>
      
    <div class="row">
    <canvas id="pci_gauge"></canvas>
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
          length: 0.7,
          strokeWidth: 0.035,
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
          {strokeStyle: "red", min: 60, max: 80},
          {strokeStyle: "darkred", min: 80, max: 100}
        ],

        highDpiSupport: true,
        angle: 0,


    };

var target = document.getElementById('pci_gauge');
var pci_gauge = new Gauge(target).setOptions(opts);
pci_gauge.maxValue = 100;
pci_gauge.setMinValue(0);
</script>
