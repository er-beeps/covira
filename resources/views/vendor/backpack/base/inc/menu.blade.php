<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->
<style>

#home_btn,#about_btn, #teams_btn {
    height:30px;
    width:auto;
    position : relative;
    color:white;
    background-color:#2f353a;
    text-align:center;
    border:none;
    font-size:17px;
}
#home_btn:hover,#about_btn:hover,#teams_btn:hover {
    height:30px;
    width:auto;
    position : relative;
    background-color:lightgray;
    color:black;
}
</style>

<ul class="nav navbar-nav">

    @if (backpack_auth()->check())
        <!-- Topbar. Contains the left part -->
        @include(backpack_view('inc.topbar_left_content'))
    @else    
    <div class="row">   
        <a id="home_btn"  class = "btn btn-sm btn-secondary" style="margin-left:10px;" href="{{ url('/') }}">{{ trans('Home') }}</a>
        <a id="about_btn"  class = "btn btn-sm btn-secondary" style="margin-right:0px;" href="{{ url('/about') }}">{{ trans('About') }}</a>
        <!-- <a id ="teams_btn" class = "btn btn-sm btn-secondary" style="margin-left:20px;" href="{{ url('/teams') }}">{{ trans('Our Team') }}</a> -->
    </div>    
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto" style="margin-right:30px;">

    @if (backpack_auth()->guest())
    <div class = "col-md-4">
        <div class="row">   
        <a style="margin-right:10px; color:white" href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a>
        </div>
        @if (config('backpack.base.registration_open'))
        <div class="row">
        <a style="color:white;"href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a>
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
