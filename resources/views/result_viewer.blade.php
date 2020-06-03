<div id = "result_viewer">
<script src="{{asset('js/gauge.js')}}"></script>

    <div class="row">
        <div class="col-md-12 col-md-8 col-md-4 col-md-2">
            <div class ="row">
                <div class="col-md-12 col-md-8 col-md-4" style="text-align:center">
                    <h5><b>Risk Assessment Result !!</b></h5>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-5 col-md-3">
                    <div class="card side-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header"><center><b>{{trans('COVID Risk Index')}}</b></center></div>
                        <div class="card-body">
                            @include(backpack_view('inc.cri_gauge'))
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-md-4">
                    <div class="card  side-card" style="background-color: #bafdd0; background-size:cover">
                        <div class="card-header"><center><b>{{trans('Probability of COVID Infection')}}</b></center></div>
                        <div class="card-body">
                            @include(backpack_view('inc.pci_gauge'))
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
            <div class="social-share">
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