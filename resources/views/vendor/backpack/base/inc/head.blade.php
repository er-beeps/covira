@php
$responseId = request()->session()->get('response_id');
$response = \App\Models\Response::find($responseId);
if($response != NULL){
$cri = $response->covid_risk_index;
$pci = $response->probability_of_covid_infection;
}else{
$cri = NULL;
$pci = NULL;
}
@endphp


<script>
function keyCheck(key){
    // var key = sessionStorage.getItem("key");
    if(key){
    document.cookie = "key ="+key;
    }
}
</script>

<?php
$key = $_COOKIE['key'];
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <meta property="og:url"           content="https://covira.info" />
    <meta property="fb:app_id"        content="277695410085664" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Assess yours risk here" />
    <meta property="og:description"   content="COVIRA- web application to calculate your Personal and Regional Risk" />
    @if($key == "dashboard")
    <meta property="og:image"         content="https://covira.info/img/result_view.jpg" />
    @else
    <meta property="og:image"         content="https://covira.info/img/map.png" />
    @endif

    @if (config('backpack.base.meta_robots_content'))<meta name="robots" content="{{ config('backpack.base.meta_robots_content', 'noindex, nofollow') }}"> @endif

    <meta name="csrf-token" content="{{ csrf_token() }}" /> {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <title>{{ isset($title) ? $title.' :: '.config('backpack.base.project_name') : config('backpack.base.project_name') }}</title>
    <link rel="icon" sizes="120x120" type="image/png" href="{{ asset('/img/title_logo.png')}}">

    @yield('before_styles')
    @stack('before_styles')
    
    @if (config('backpack.base.styles') && count(config('backpack.base.styles')))
        @foreach (config('backpack.base.styles') as $path)
        <link rel="stylesheet" type="text/css" href="{{ asset($path).'?v='.config('backpack.base.cachebusting_string') }}">
        @endforeach
    @endif

    @if (config('backpack.base.mix_styles') && count(config('backpack.base.mix_styles')))
        @foreach (config('backpack.base.mix_styles') as $path => $manifest)
        <link rel="stylesheet" type="text/css" href="{{ mix($path, $manifest) }}">
        @endforeach
    @endif

    @yield('after_styles')
    @stack('after_styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->