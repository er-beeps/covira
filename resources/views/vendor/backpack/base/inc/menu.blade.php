<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->


<ul class="nav navbar-nav">

    @if (backpack_auth()->check())
        <!-- Topbar. Contains the left part -->
        @include(backpack_view('inc.topbar_left_content'))
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto" style="margin-right:30px;">

    @if (backpack_auth()->guest())
    <li class="nav-item dropdown d-md-down-none">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="color:white;">
          {{ strtoupper(app()->getLocale()) }}
        </a>
        <div class="dropdown-menu dropdown-menu-right">
         @foreach(config('app.languages') as $langLocale => $langName)
          <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
          @endforeach
        </div>
      </li>
    <div class = "col-md-4">
        <div class="row">   
        <a style="margin-right:10px; color:white" href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
        </div>
        @if (config('backpack.base.registration_open'))
        <div class="row">
        <!-- <a style="color:white;"href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a> -->
        </div>
        @endif
    </div>    
    @else
        <!-- Topbar. Contains the right part -->
        @include(backpack_view('inc.topbar_right_content'))
        @include(backpack_view('inc.menu_user_dropdown'))
    @endif
</ul>
<!-- ========== End of top menu right items ========== -->
