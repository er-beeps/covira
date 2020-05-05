@extends(backpack_view('blank'))

@section('header')
<section class="content-header">
    <h1>
        Response in GIS Map
    </h1>
</section>
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('/gismap/css/gismap.css') }}" />
<link rel="stylesheet" href="{{ asset('/gismap/css/mapview.css') }}" />
<link href="{{ asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/vendor/adminlte/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<!-- <script src="{{asset('js/dependentdropdown.js') }}"></script>
<script src="{{asset('js/accordion.js') }}"></script> -->
<!-- <script src="{{asset('vendor/adminlte/plugins/select2/select2.full.min.js') }}"></script> -->

<div class="row"> 
    <div class="box-body">
        <div class="col-md-12">
            <div class="box box-default collapsed box-solid">
                <div class="box-header with-border ">
                    <h3 class="box-title">Search</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool btn-block" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
        
                <div class="box-body">
                    <form class="form-horizontal">
                        <div class="form-group" style="margin-right: 0px;">

                            <label for="inputEmail3" class="col-sm-1 control-label">Province</label>
                            
                            <div class="col-sm-2">
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

                            <label for="inputEmail3" class="col-sm-1 control-label">District</label>
                            <div class="col-sm-3">
                                <select class="form-control select2" style="width: 100%;" name="district" id="district">
                                </select>
                            </div>

                            <label for="inputEmail3" class="col-sm-1 custom-label control-label">Local Level</label>
                            <div class="col-sm-3">
                                <select class="form-control select2" style="width: 100%;" name="local_level" id="local_level">
                              
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info col-sm-1"><i class="fa fa-search"></i>Search</button>
                        </div>
                </div>
            </div>
        </div>


        <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="pad">
                                <div class="map-tab">
                                    <div class="tab">
                                        <ul class="nav nav-tabs">
                                            <li class="active" id="tabspan">
                                                <a href="#activity" data-toggle="tab" class="streets">
                                                    <div data-toggle="tooltip" data-placement="bottom" title="Open Streets Map" style="width:26px">
                                                        <img class="open-street" src="/css/images/open_street_map1.ico" width="26px"></div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#timeline" data-toggle="tab" class="streets">
                                                    <div data-toggle="tooltip" data-placement="bottom" title="Google Map">
                                                        <img class="" src="/css/images/google-map.png" width="26px">
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class=" active tab-pane" id="activity" style="margin-top: 1%;">
                                        <link rel="stylesheet" href="{{ asset('/gismap/css/leaflet.css') }}" />
                                        <script src="{{ asset('/gismap/js/leaflet-src.js') }}"></script>
                                        <link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.css') }}" />
                                        <link rel="stylesheet" href="{{ asset('/gismap/css/MarkerCluster.Default.css') }}" />
                                        <script src="{{ asset('/gismap/js/leaflet.markercluster-src.js') }}"></script>
                                        <div class="map-body">
                                            <div id="map"></div>
                                            <link rel="stylesheet" href="{{ asset('/gismap/css/Control.FullScreen.css') }}" />
                                            <script src="{{ asset('/gismap/js/Control.FullScreen.js') }}"></script>
                                            <script>
                                                var json = <?php echo $markers; ?>
                                            </script>
                                            <script src="{{ asset('/gismap/js/leafletopenstreet.js') }}"></script>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="timeline" style="margin-top: 1%;">
                                        <div class="map-body">
                                            <div id="map1"></div>
                                                <script src="{{ asset('/gismap/js/oms.min.js') }}"></script>
                                                <script>
                                                    var json = <?php echo $markers; ?>
                                                </script>
                                                <script src="{{ asset('/gismap/js/googlemap.js') }}"></script>
                                                <script src="{{ asset('/gismap/js/markerclusterer_compiled.js') }}"></script>
                                                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoEoSKYFDXovqwCwCHIhAYGFsnrUW09Oo&callback=initMap"></script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection 