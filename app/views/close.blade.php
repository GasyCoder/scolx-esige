@extends('backend.main')
<?php $control = Control::find(1); ?>
<?php $path = Session::get('language'); ?>


@section('metaTages') 
<meta name="keywords" content="{{ $control->keywords }}">
<meta name="description" content="{{ $control->description }}">
@stop

@section('title') {{ Lang::get($path.'.site_is_closed') }} @stop

@section('content')

<div class="articles">


<div class="col-md-8 col-md-offset-2" style="margin-top: 100px;">

  <div class='alert alert-info center'>
    <br><i class="glyphicon glyphicon-hourglass" style="font-size: 32px;"></i>
    <h2 style="color:red">{{ Lang::get($path.'.site_is_closed') }}</h2>
    <p style="color:#333">{{ $msg }}</p>
  </div>

</div>


</div>

@stop