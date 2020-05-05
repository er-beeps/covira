@extends(backpack_view('layouts.top_left'))

@section('header')
<section class="content-header">
    <h2>GIS Map</h2>
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




<div class="row">
    <div class="col-md-12">

        <div class="card bg-light">
            <div class="card-header" style="background-color: lightgray; height:45px;"><h5>Search</h5>
            </div>
            <div class="card-body" style="background-color: white;">
                <form>
                <div class="row">
                        <div class="form-inline col-md-3">
                            <label>Province</label>
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

                        <div class="form-inline col-md-3">
                            <label for="district">District</label>
                            <select class="form-control select2" style="width: 100%;" name="district" id="district"></select>
                        </div>

                        <div class="form-inline col-md-3">
                            <label for="locallevel">Local Level</label>
                                <select class="form-control select2" style="width: 100%;" name="local_level" id="local_level"></select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>Search</button>
                        </div>
                    </div> <!-- row ends here -->
                </form>    
            </div>  <!-- card-body ends here -->
        </div>
    </div> 
</div>




<div class="row">
    <div class="col-md-10">

        <div class="card bg-light">
            <div class="card-header" style="background-color: lightgray; height:50px;">
                <div class = "map-tab col-md-2">
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="#activity" data-toggle="tab" class="streets">
                                <div data-toggle="tooltip" data-placement="bottom" title="Open Streets Map">
                                    <img class="open-street" src="/css/images/open_street_map1.ico" width="30px">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#timeline" data-toggle="tab" class="streets">
                                <div data-toggle="tooltip" data-placement="bottom" title="Google Map">
                                    <img class="" src="/css/images/google-map.png" width="30px">
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body" style="background-color: white;">

                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <div class="map-body">
                            <div id="map"></div>
                            <script>
                                var json = <?php echo $markers; ?>
                            </script>
                        </div>
                    </div>

                    <div class="tab-pane" id="timeline">
                        <div class="map-body">
                            <div id="map1"></div> 
                                <script>
                                    var json = <?php echo $markers; ?>
                                </script>   
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>  <!-- card-body ends here -->
        </div>
    </div> 
</div>
    
@endsection

<script src="{{asset('js/dependentdropdown.js') }}"></script>
<script src="{{asset('js/accordion.js') }}"></script>
<script src="{{ asset('/gismap/js/oms.min.js') }}"></script>
<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>

<script src="{{ asset('/gismap/js/leaflet.markercluster-src.js') }}"></script>
 <script src="{{ asset('/gismap/js/Control.FullScreen.js') }}"></script>
<script src="{{ asset('/gismap/js/leafletopenstreet.js') }}"></script>
 <script src="{{ asset('/gismap/js/googlemap.js') }}"></script>
<script src="{{ asset('/gismap/js/markerclusterer_compiled.js') }}"></script>
<script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoEoSKYFDXovqwCwCHIhAYGFsnrUW09Oo&callback=initMap"></script>


