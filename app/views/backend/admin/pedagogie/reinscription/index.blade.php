@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }} @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h1>Vérifier étudiant </h1>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
       <div class="breadcrumb breadcrumb_alt container flex items-center justify-center py-10">
        <div class="w-full md:w-1/2 xl:w-1/3">
        {{ Form::open(['route'=>'reInscrit', 'method'=>'GET', 'id'=>'myForm', 'class'=>'hidden md:block'])  }}
            <label class="form-control-addon-within rounded-full">
                
                @if(Input::has('q'))
                    {{ Form::text('q', Input::get('q'), ['class'=>'form-control border-none']) }}
                @else
                    {{ Form::text('q', '', [ 'placeholder'=>'Veuillez saisir le numéro matricule, nom ou prénom de l\'étudiant', 'class'=>'form-control border-none']) }}
                @endif
                <button type="submit" class="btn btn-link text-gray-300 dark:text-gray-700 dark:hover:text-primary text-xl leading-none la la-search ltr:mr-4 rtl:ml-4"></button>
            </label>
        {{ Form::close() }}
        </div>
        </div>   
@include('backend.pages.footer')
</main>
@stop