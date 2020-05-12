@extends(backpack_view('layouts.top_left'))

@section('header')
<section class="content-header">
</section>
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('/gismap/css/gismap.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/mapview.css') }}" />
<link href="{{ asset('css/responsive.bootstrap.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
 <link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.Default.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/Control.FullScreen.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/leaflet.css') }}" />

<div class ="row">
    <div class="col-md-2">
        <div class="row">
            <div class="card col-md-12 side-card">
                <div class="card-header">Some header</div>
                <div class="card-body">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col-md-12 side-card">
                <div class="card-header">Some header</div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light head-card">
                    <div class="card-body" style="background-color: lightgray; max-height:50px;">
                        <form>
                            <div class="row" style="margin-top:-10px;">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="form-inline col-md-4">
                                            {{-- <label>Province</label> --}}
                                            <select class="form-control select2" name="province" id="province" style="width: 100%;">
                                            <option selected disabled style="font-weight:bold;">प्रदेश छान्नुहोस्</option>
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
                                            </select>
                                        </div>

                                        <div class="form-inline col-md-4">
                                            {{-- <label for="locallevel">Local Level</label> --}}
                                                <select class="form-control" style="width: 100%;" name="local_level" id="local_level"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">    
                                    <div class="row">
                                        <div class="form-inline">
                                            <button type="submit" class="btn btn-primary btn-sm" style="margin: 0px 0px 0px 10px;"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                        <div class="form-inline">
                                            <a href="{{url('/')}}" type="reset" class="btn btn-warning btn-sm" style="margin: 0px 13px;"><i class="fa fa-refresh"></i> Reset</a>
                                        </div>
                                        <div class="form-inline">
                                                <a href="response/create" class="btn btn-success btn-sm" style="margin-left:0px; float:right">Assess your risk</a>
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
                                <li>
                                    <a href="#open_street" data-toggle="tab" class="active streets">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Open Streets Map">
                                            <img class="" src="/css/images/open_street_map1.ico" width="30px">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#google_map" data-toggle="tab" class="streets">
                                        <div data-toggle="tooltip" data-placement="bottom" title="Google Map">
                                            <img class="" src="/css/images/google-map.png" width="30px">
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="active tab-pane" id="open_street">
                            <div class="map-body">
                                <div id="map"></div>
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>
                            </div>
                        </div>

                        <div class="tab-pane" id="google_map">
                            <div class="map-body">
                                <div id="map1"></div> 
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>   
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <div class="col-md-2">
          <div class="row">
            <div class="card col-md-12 side-card">
                <div class="card-header">Some header</div>
                <div class="card-body">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col-md-12 side-card">
                <div class="card-header">Some header</div>
                <div class="card-body">
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

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoEoSKYFDXovqwCwCHIhAYGFsnrUW09Oo&callback=initMap"></script>

@endsection

