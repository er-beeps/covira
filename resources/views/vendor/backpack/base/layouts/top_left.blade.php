<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">

<head>
    <meta property="og:url"           content="https://covira.info" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="Access your risk here" />
    <meta property="og:description"   content="COVIRA:: A web application to calculate your Personal and Regional Risk" />
    <meta property="og:image"         content="https://covira.info/img/result_view.png" />
<script data-ad-client="ca-pub-4021645191234924" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  @include(backpack_view('inc.head'))


</head>

<body class="{{ config('backpack.base.body_class') }}">

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v7.0&appId=277695410085664&autoLogAppEvents=1"></script>

  @include(backpack_view('inc.main_header'))

  <div class="app-body">

    @include(backpack_view('inc.sidebar'))

    <main class="main pt-2">

       {{-- @includeWhen(isset($breadcrumbs), backpack_view('inc.breadcrumbs')) --}}

       @yield('header')

        <div class="container-fluid animated fadeIn">

          @yield('before_content_widgets')

          @yield('content')
          
          @yield('after_content_widgets')

        </div>

    </main>

  </div><!-- ./app-body -->

  {{-- <footer class="{{ config('backpack.base.footer_class') }}">
    @include(backpack_view('inc.footer'))
  </footer> --}}

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>