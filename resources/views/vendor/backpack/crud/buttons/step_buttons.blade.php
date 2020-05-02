@if(isset($current_step_id) && ($current_step_id < 3))
    <button type ="submit" class="btn btn-primary btn-next">{{ trans('Proceed Next') }}<i class="fa fa-angle-right"></i></button>

    {{-- <a  href= "{{backpack_url('response/'.$entry->getKey().'/nextstep')}}" class="btn btn-primary btn-next" data-process = "nextstep">{{ trans('Proceed Next') }}<i class="fa fa-angle-right"></i></a> --}}
@else
    <button type ="submit" class="btn btn-primary btn-next"><i class="fa fa-database"></i>{{ trans('  Submit') }}</button>

    {{-- <a  href= "{{backpack_url('response/'.$entry->getKey().'/nextstep')}}" class="btn btn-primary btn-next" data-process = "submit"><i class="fa fa-database"></i>{{ trans('Submit') }}</a> --}}
@endif