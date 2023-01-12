<?php 
$path = Session::get('language');
$control = Control::find(1); 
?> 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Generics -->
    <link rel="icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="32x32">
    <link rel="icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="128x128">
    <link rel="icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="192x192">
    <!-- Android -->
    <link rel="shortcut icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="196x196">
    <!-- iOS -->
    <link rel="apple-touch-icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="167x167">
    <link rel="apple-touch-icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="180x180">
    
    {{ HTML::style('public/assets/css/style.css') }}
    {{ HTML::style('public/assets/css/keywords.css') }}
    {{ HTML::style('public/assets/css/picker.css') }}
    {{ HTML::style('public/assets/css/css_datatable.css') }}
    {{ HTML::script('public/assets/js/jquery-3.6.0.js') }}
    {{ HTML::script('public/assets/js/jquery-ui.js') }}
    <script>
      $( function() {
        $( "#datepicker" ).datepicker();
      } );
    </script>
    {{ HTML::style('public/assets/js/Manage/vendor/select2/dist/css/select2.min.css') }}
    {{ HTML::style('public/assets/js/Manage/css/argon.css?v=1.2.0') }}
    @yield('css')
</head>
<body>
     @include('backend.pages.header')
     @include('backend.pages.side')
     @include('backend.pages.custum')          

    @yield('content')

    <!-- Scripts -->
    <script src="{{ url() }}/public/assets/js/vendor.js"></script>
    <script src="{{ url() }}/public/assets/js/chart.min.js"></script>
    <script src="{{ url() }}/public/assets/js/script.js"></script>
    
    <script src="{{ url() }}/public/assets/js/table/datatable.js"></script><!--sort table class-->
    <script src="{{ url() }}/public/assets/js/table/demo.js"></script><!--function table-->
    <script src="{{ url() }}/public/assets/js/table/select.js"></script>
    <script src="{{ url() }}/public/assets/js/Manage/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ url() }}/public/assets/js/Manage/js/argon.js?v=1.2.0"></script>
    @yield('js')
</body>
</html>