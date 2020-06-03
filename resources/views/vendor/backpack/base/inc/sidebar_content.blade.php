<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('response') }}'><i class='nav-icon fa fa-file'></i> Responses</a></li>
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('gismap') }}'><i class='nav-icon fa fa-map-marker'></i> GIS Map</a></li> -->

{{-- Secondary Masters --}}
@if(backpack_user()->hasanyrole('superadmin|admin'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-link-secondary nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i>{{ trans('main.secondary') }}</span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('prhospital') }}'><i class='nav-icon fa fa-hospital-o'></i>{{ trans('main.prhospital')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('prquarantinecenter') }}'><i class='nav-icon fa fa-h-square'></i>{{ trans('main.prquarantinecenter')}}</a></li>
       
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('prfactor') }}'><i class='nav-icon fa fa-asterisk'></i>{{ trans('main.prfactor')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('practivity') }}'><i class='nav-icon fa fa-asterisk'></i>{{ trans('main.practivity')}}</a></li>
        
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('imagecategory') }}'><i class='nav-icon fa fa-picture-o'></i> Image Category</a></li>
      
    </ul>
</li>
{{-- Primary Masters --}}
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-link-secondary nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-cogs"></i>{{ trans('main.primary') }}</span></a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('country') }}'><i class='nav-icon fa fa-globe'></i> Country</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('province') }}'><i class='nav-icon fa fa-compass'></i> {{ trans('main.province')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('district') }}'><i class='nav-icon fa fa-compass'></i> {{ trans('main.district')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('localleveltype') }}'><i class='nav-icon fa fa-compass'></i> {{ trans('main.localleveltype')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('locallevel') }}'><i class='nav-icon fa fa-compass'></i> {{ trans('main.locallevel')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('fiscalyear') }}'><i class='nav-icon fa fa-calendar'></i> {{ trans('main.fiscalyear')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('nepalimonth') }}'><i class='nav-icon fa fa-calendar'></i> {{ trans('main.nepalimonth')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('gender') }}'><i class='nav-icon fa fa-venus-mars'></i> {{ trans('main.gender')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('educationallevel') }}'><i class='nav-icon fa fa-graduation-cap'></i> {{ trans('main.educationallevel')}}</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('profession') }}'><i class='nav-icon fa fa-briefcase'></i> {{ trans('main.profession')}}</a></li>
    </ul>
</li>
@endif
@if(backpack_user()->hasanyrole('superadmin|admin'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('nepaldatacovid') }}'><i class='nav-icon fa fa-database'></i> NepalDataCovids</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('uploadimage') }}'><i class='nav-icon fa fa-picture-o'></i>Upload Images</a></li>
<li class='nav-item'><a class='nav-link nav-link-secondary' href='{{ backpack_url('user') }}'><i class='nav-icon fa fa-users'></i>{{trans('Users')}} </a></li>
@endif
