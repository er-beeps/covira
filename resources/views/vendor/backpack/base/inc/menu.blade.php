<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->


<ul class="nav navbar-nav ml-auto">

    @if (backpack_auth()->check())
        Topbar. Contains the left part
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto mr-4">

    @if (backpack_auth()->guest())
        <div class="row"> 
            <div class="col">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="color:white; float:right;">
                    {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    @foreach(config('app.languages') as $langLocale => $langName)
                    <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                    @endforeach
                    </div>
                </li>
            </div>  
            <div class="col">
                <a style="color:white" href="{{ route('backpack.auth.login') }}">{{ trans('general.login') }}</a>
            </div>
        </div>
        <!-- @if (config('backpack.base.registration_open'))
        <div class="row">
        <a style="color:white;"href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
        </div>
        @endif -->
    @else
        <!-- Topbar. Contains the right part -->
        @include(backpack_view('inc.topbar_right_content'))
        @include(backpack_view('inc.menu_user_dropdown'))
    @endif
</ul>

<!-- ========== End of top menu right items ========== -->
