@extends(backpack_view('layouts.top_left'))

@section('content')
<script src="{{asset('js/gauge.js')}}"></script>

<link rel="stylesheet" href="{{ asset('/gismap/css/gismap.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/mapview.css') }}" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
 <link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.Default.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/Control.FullScreen.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/leaflet.css') }}" />
<style>
table.nepal_data_table tr td.data{
    margin-left:50px;
}
</style>

<div class ="row">
    <div class="col-md-2">
        <!-- <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightgray; background-size:cover;">
                <div class="card-header"><center><b>COVIRA ड्यासबोर्ड</b></center></div>
            </div>
        </div> -->

        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightblue; background-size:cover;">
                <div class="card-header">
                @if(backpack_user())
                    <center><a href="{{backpack_url('response/create')}}" style="color:blue; font-size:18px;"><b>{{trans('dashboard.accessrisk')}}</b></a><center>
                @else
                    <center><a href="fill_response/create" style="color:blue; font-size:18px;"><b>{{trans('dashboard.accessrisk')}}</b></a><center>
                @endif    
                </div>
            </div>
        </div>
        @if(backpack_user())
            @php
            $id = \App\Models\Response::where('user_id',backpack_user()->id)->pluck('id')->first();
            @endphp
            <div class="row">
                <div class="card col-md-12 side-card" style="background-color: #bafdd0; background-size:cover">
                    <div class="card-header"><center><b>{{trans('dashboard.covidriskindex')}}</b></center></div>
                    <div class="card-body">
                    @if(isset($id))
                            @include(backpack_view('inc.cri_gauge'))
                    @else
                    <span style="color:red;"><b>{{trans('dashboard.accessriskwarning')}}</b></span>
                    @endif        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-md-12 side-card" style="background-color: bisque; background-size:cover">
                    <div class="card-header"><center><b>{{trans('dashboard.covidchance')}}</b></center></div>
                    <div class="card-body">
                    @if(isset($id))
                            @include(backpack_view('inc.pci_gauge'))
                    @else
                        <span style="color:red;"><b>{{trans('dashboard.covidchance')}}</b></span>
                    @endif  
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-md-12 side-card" style="background-color: lightgreen; background-size:cover;">
                    <div class="card-header">
                        <center><a href="{{backpack_url('/response'.'/'.$id.'/edit')}}" style="color:blue; font-size:18px;"><b>{{trans('dashboard.survey')}}</b></a><center>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light head-card">
                    <div class="card-body" style="background-color: lightgray; max-height:50px;">
                        <form>
                            <div class="row" style="margin-top:-10px;">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="form-inline col-md-4">
                                            {{-- <label>Province</label> --}}
                                            <select class="form-control select2" name="province" id="province" style="width: 100%;">
                                            <option selected disabled style="font-weight:bold;">{{trans('dashboard.province')}}</option>
                                            @foreach($area_province as $ap)

                                            @if(isset($selected_params['province']) && $ap->id == $selected_params['province'])
                                                <option class="form-control nepali_td" SELECTED value="{{ $ap->id }}">{{ $ap->code }}-{{ $ap->name_lc }}-{{ $ap->name_en }}</option>
                                                @else
                                                <option class="form-control nepali_td" value="{{ $ap->id }}">{{ $ap->code }}-{{ $ap->name_lc }}-{{ $ap->name_en }}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>

                                        <div class="form-inline col-md-4">
                                            {{-- <label for="district">District</label> --}}
                                            <select class="form-control" style="width: 100%;" name="district" id="district">
                                            <option selected disabled style="font-weight:bold;">{{trans('dashboard.district')}}</option>
                                            </select>
                                        </div>

                                        <div class="form-inline col-md-4">
                                            {{-- <label for="locallevel">Local Level</label> --}}
                                                <select class="form-control" style="width: 100%;" name="local_level" id="local_level"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">    
                                    <div class="row">
                                        <div class="form-inline">
                                            <button type="submit" class="btn btn-primary btn-md" style="margin: 0px 0px 0px 10px;"><i class="fa fa-search"></i> {{trans('dashboard.search')}}</button>
                                        </div>
                                        <div class="form-inline">
                                            <a href="{{url('/')}}" type="reset" class="btn btn-warning btn-md" style="margin: 0px 13px;"><i class="fa fa-refresh"></i>{{trans('dashboard.reset')}}</a>
                                        </div>
                                    </div>
                                </div>    
                            </div> <!-- row ends here -->
                        </form>    
                    </div>  <!-- card-body ends here -->
                </div>
            </div> 
        </div>
    

        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light map-card">
                    <div class="card-header map-card-header" style="background-color: lightgray">
                        <div class = "map-tab">
                            <ul class="nav nav-tabs">
                                {{-- <li class="for_map">
                                    <a href="#open_street" data-toggle="tab" class="streets">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Open Streets Map">
                                            <img class="" src="/css/images/open_street_map1.ico" width="30px">
                                        </div>
                                    </a>
                                </li> --}}
                                <li class="for_map">
                                    <a href="#google_map" data-toggle="tab" class="active streets">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Google Map">
                                            <img class="" src="/css/images/google-map.png" width="30px">
                                        </div>
                                    </a>
                                </li>
                                <li class="for_chart">
                                    <a href="#risk_map" data-toggle="tab" class="riskmap">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Risk Map">
                                            <button class="btn btn-secondary btn-sm btn-map" style="border:1px solid black;">{{trans('dashboard.riskmap')}}</button>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane" id="open_street">
                            <div class="map-body">
                                <div id="map"></div>
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>
                            </div>
                        </div>

                        <div class="active tab-pane" id="google_map">
                            <div class="map-body">
                                <div id="map1"></div> 
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>   
                            </div>
                        </div>
                        <div class="tab-pane" id="risk_map">
                            <div class="map-body">
                                <div id="risk_image"></div> 
                               <img id ="image1" src = "{{asset('storage/uploads/'.$risk_map_path)}}"></img>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <div class="col-md-2">
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: #bafdd0; background-size:cover">
                <div class="card-header"><center><b style="font-size:18px;">{{trans('dashboard.covidnepal')}}</b><center></div>
                <div class="card-body ">
                        <table class="nepal_data_table" style="margin-left:-20px; font-size:14px;">
                            <tr>
                                <td class="title"><i class="fa fa-dot-circle-o" style="color:orange; font-weight:bolder"> &nbsp;</i>{{trans('dashboard.infected')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_affected ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title"><i class="fa fa-dot-circle-o" style="color:green; font-weight:bolder"> &nbsp;</i>{{trans('dashboard.recovered')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_recovered ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title"><i class="fa fa-dot-circle-o" style="color:gray; font-weight:bolder"> &nbsp;</i>{{trans('dashboard.isolation')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_isolation ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title"><i class="fa fa-dot-circle-o" style="color:red; font-weight:bolder"> &nbsp;</i>{{trans('dashboard.deaths')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_death ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title"><i class="fa fa-dot-circle-o" style="color:rgb(203, 71, 226); font-weight:bolder"> &nbsp;</i>{{trans('dashboard.swab_test')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_swab_test ?? '0'}}</td>
                            </tr>
                            <tr>
                                <td class="title"><i class="fa fa-dot-circle-o" style="color:blue; font-weight:bolder"> &nbsp;</i>{{trans('dashboard.quarantine')}}</td>
                                <td class="data"> {{$nepal_covid_data->total_quarantine ?? '0'}}</td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightgreen; background-size:cover;">
                <div class="card-header">
                    <center><a target="_blank" href="https://www.worldometers.info/coronavirus/" style="color:blue; font-size:18px;"><b>{{trans('dashboard.worldupdates')}}</b></a><center>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color:bisque; background-size:cover;">
                <div class="card-header">
                    <center><a target="_blank" href="https://heoc.mohp.gov.np/update-on-novel-corona-virus-covid-19/" style="color:blue; font-size:17px;"><b>{{trans('dashboard.covid_guidelines')}}</b></a><center>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col-md-12 side-card" style="background-color: lightgray; background-size:cover;">
                <div class="card-header">
                    <center><a target="_blank" href="https://www.who.int/emergencies/diseases/novel-coronavirus-2019?gclid=CjwKCAjw5cL2BRASEiwAENqAPngAvVQESLDpig3crKIIaGLOmmAflAkyRa8lrvBPUAtaKIX-pbwOKhoCDWwQAvD_BwE" style="color:darkblue; font-size:17px;"><b>{{trans('dashboard.covid_updates')}}</b></a><center>
                </div>
            </div>
        </div>
    </div>       
</div>

    
<script src="{{asset('js/dependentdropdown.js') }}"></script>
<script src="{{ asset('/gismap/js/oms.min.js') }}"></script>
<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>

<script src="{{ asset('/gismap/js/leaflet.markercluster-src.js') }}"></script>
 <script src="{{ asset('/gismap/js/Control.FullScreen.js') }}"></script>
<script src="{{ asset('/gismap/js/leafletopenstreet.js') }}"></script>
 <script src="{{ asset('/gismap/js/googlemap.js') }}"></script>
<script src="{{ asset('/gismap/js/markerclusterer_compiled.js') }}"></script>
<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoEoSKYFDXovqwCwCHIhAYGFsnrUW09Oo&callback=initMap"></script>

@endsection

