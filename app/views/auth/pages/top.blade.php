<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
</head>
<body>

@yield('content')


    <!-- Scripts -->
    <script src="{{ url() }}/public/assets/js/vendor.js"></script>
    <script src="{{ url() }}/public/assets/js/chart.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1"></script> -->
    <script src="{{ url() }}/public/assets/js/script.js"></script>
</body>
</html>