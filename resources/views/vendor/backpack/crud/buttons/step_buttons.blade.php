@if(isset($back_btn) && ($current_step_id > 1 && $current_step_id <= 3))
    @if(backpack_user())
        <a  href= "{{backpack_url('response/'.$entry->getKey().'/backstep')}}" class="btn btn-primary btn-back" data-process = "backstep"><i class="fa fa-angle-left"></i>{{ trans('Go Back') }}</a>
    @else
        <a  href= "{{url('/response'.'/'.$entry->getKey().'/backstep')}}" class="btn btn-primary btn-back" data-process = "backstep"><i class="fa fa-angle-left"></i>{{ trans('Go Back') }}</a>
    @endif
@endif  

@if(isset($current_step_id) && ($current_step_id < 3))
    <button type ="submit" class="btn btn-primary btn-next">{{ trans('Proceed Next') }}<i class="fa fa-angle-right"></i></button>
@else
    <button type ="submit" class="btn btn-primary btn-next"><i class="fa fa-database"></i>{{ trans('  Submit') }}</button>
@endif


    {{-- <a  href= "{{backpack_url('response/'.$entry->getKey().'/nextstep')}}" class="btn btn-primary btn-next" data-process = "nextstep">{{ trans('Proceed Next') }}<i class="fa fa-angle-right"></i></a> --}}