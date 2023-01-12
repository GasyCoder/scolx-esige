@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}@stop
@section('content')
<main class="workspace">


@include('backend.pages.footer')
</main>
@stop