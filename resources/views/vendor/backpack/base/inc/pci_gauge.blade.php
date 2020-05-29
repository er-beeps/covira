<script src="{{asset('js/gauge.js')}}"></script>

<style>
    .pci_title{
    text-align: center;
  }
  #pci_gauge_view{
    height:75px;
    width:150px;
    margin-left:-40px;
  }
  .index{
    margin:0px;
  }

  #index{
    margin-left:-30px;
  }
  span.indicator-box {
    /* margin-bottom:5px; */
    margin-right:5px;
    margin-left:0px;
  }
  .indicator-box{
    width:10px;
    height:10px;
    margin:auto;
    display: inline-block;
    border:1px solid gray;
    border-radius: 3px;
  }
  .indicator-label{
    font-family: 'Times New Roman', Times, serif;
    font-size: 10px;
    font-weight:bold;
    margin-bottom:0px;
  }

  </style>

<div class="col-md-12">   
    <div class="row">
        <div class = "col-md-5 index">
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
                <td><span class="indicator-box" style= "background-color:red"></td>
                <td><span class="indicator-label">High</span></td>
            </tr>
            <tr>
                <td><span class="indicator-box" style= "background-color:darkred"></td>
                <td><span class="indicator-label">Very High</span></td>
            </tr>
            </table>
        </div>

        <div class="col-md-7">
            <canvas id="pci_gauge_view"></canvas>
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

var target = document.getElementById('pci_gauge_view');
var pci_gauge_view = new Gauge(target).setOptions(opts);
pci_gauge_view.maxValue = 100;
pci_gauge_view.setMinValue(0);
</script>
