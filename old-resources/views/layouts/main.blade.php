<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default"
      data-bs-theme="light" data-layout-width="fluid" data-layout-position="fixed" data-layout-style="default"
      data-body-image="none" data-sidebar-visibility="show">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="token" content="{{csrf_token()}}">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <title>@yield('title')</title>
</head>
<body>
@include('components.main.navigation')
<div class="page-content">
    @yield('content')
</div>
@yield('scripts')
</body>
</html>
