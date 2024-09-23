<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="default" data-layout="horizontal" data-topbar="light" data-sidebar="light" data-preloader="disable">
<!doctype html>

<head>
    <meta charset="utf-8" />
    <meta name="token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{asset('build/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('build/libs/echarts/echarts.min.js')}}"></script>
    <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
{{--    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />--}}
{{--    <meta content="Themesbrand" name="author" />--}}
{{--    <!-- App favicon -->--}}
{{--    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">--}}
    @include('layouts.head-css')
    @vite(['resources/custom-scss/app.scss'])
</head>

@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js')}}"></script>
    <!-- dashboard init -->
    <script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

@endsection

@section('body')
@include('layouts.body')
@show

<!-- Begin page -->
<div id="layout-wrapper">
    @include('layouts.topbar')
    @include('layouts.sidebar')

{{--    modals--}}
    @include('actives.create')
    @yield('modals')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

@include('layouts.customizer')

<!-- JAVASCRIPT -->
@include('layouts.vendor-scripts')
@vite(['resources/custom-js/actives/main.js', 'resources/custom-js/tickers/main.js'])
</body>

</html>
