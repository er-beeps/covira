@if(backpack_user() && backpack_user()->hasanyrole('superadmin|admin'))
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
@else
        <div class="row">
            <div class="col-md-12 col-md-8 col-md-4">
                <div class="card bg-light head-card">
                    <div class="card-body" style="background-color: lightgray;">
                        <form method="POST" action="{{url('/searchregionalrisk')}}" id ="search-form">
                        {!! csrf_field() !!}
                            <div class="row" style="margin-top:-10px;">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="form-inline col-md-4">
                                             <label>{{trans('dashboard.province')}}</label>
                                            <select class="form-control select2" name="province" id="province" style="width: 100%;">
                                            <option selected disabled style="font-weight:bold;">{{trans('dashboard.select_province')}}</option>
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
                                            <label for="district">{{trans('dashboard.district')}}</label>
                                            <select class="form-control" style="width: 100%;" name="district" id="district">
                                            <option selected disabled style="font-weight:bold;">{{trans('dashboard.select_district')}}</option>
                                            </select>
                                        </div>

                                        <div class="form-inline col-md-4">
                                             <label for="locallevel">{{trans('dashboard.local_level')}}</label>
                                                <select class="form-control" style="width: 100%;" name="local_level" id="local_level"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">    
                                    <div class="row">
                                        <div class="form-inline">
                                            <button type="submit" class="btn btn-primary btn-md" style="margin: 12px 0px 0px 10px;"><i class="fa fa-search"></i> {{trans('dashboard.searchregionalrisk')}}</button>
                                        </div>
                                        <!-- <div class="form-inline">
                                            <a href="{{url('/')}}" type="reset" class="btn btn-warning btn-md" style="margin: 0px 13px;"><i class="fa fa-refresh"></i>{{trans('dashboard.reset')}}</a>
                                        </div> -->
                                    </div>
                                </div>    
                            </div> <!-- row ends here -->
                        </form>    
                    </div>  <!-- card-body ends here -->
                </div>
            </div> 
        </div>      
@endif
