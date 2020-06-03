<div id = "result_viewer">
<script src="{{asset('js/gauge.js')}}"></script>

    <div class="row">
    <div class="col-md-12">
        <div class ="row">
            <div class="col-md-12" style="text-align:center">
            <h5><b>Risk Assessment Result !!</b></h5>
        </div>
        </div>
    <br>
        <div class="row">
            <div class="col-md-6">
                <div class="card col-md-12 side-card" style="background-color: #bafdd0; background-size:cover">
                    <div class="card-header"><center><b>{{trans('COVID Risk Index')}}</b></center></div>
                    <div class="card-body">
                        @include(backpack_view('inc.cri_gauge'))
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card col-md-12 side-card" style="background-color: #bafdd0; background-size:cover">
                    <div class="card-header"><center><b>{{trans('Probability of COVID Infection')}}</b></center></div>
                    <div class="card-body">
                        @include(backpack_view('inc.pci_gauge'))
                    </div>
                </div>
            </div>
        </div>    
        </div>
    </div>
</div>


<style>
  #result_viewer{
      border-radius:25px;
      margin-bottom:10%;
      margin-left:5%;
      max-width:90%;
      max-height:80%;
  }
  </style>