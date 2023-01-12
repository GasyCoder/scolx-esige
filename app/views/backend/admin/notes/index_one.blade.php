@extends('backend.main')
<?php $path = Session::get('language'); ?>

@section('title') Ajouter les notes - {{$year->yearsUniv}} @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-4">
            <h3>{{$title}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            </div>
        </section>
@if(count($classes) >= 1)
   <div class="p-4">
            <div class="overflow-x-auto">
                <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-5">
                 <a href="/admin/ajouter_notes/anne_preparatoire/1">    
                    <div class="card card_hoverable card_list">
                        <div class="image image_icon">
                            <span class="la la-user-graduate la-4x"></span>
                        </div>
                        <div class="body">
                            <h6>{{ $kilasy->name }}</h6>
                            <p class="font-bold">{{ $kilasy->short }}</p>
                        </div>
                    </div>
                    </a>   
                 @foreach($classes as $class)
                 @if($class->id > 1)
                 <a href="{{ URL::current().'/'.$class->id}}">    
                    <div class="card card_hoverable card_list">
                        <div class="image image_icon">
                            <span class="la la-user-graduate la-4x"></span>
                        </div>
                        <div class="body">
                            <h6>{{ $class->name }}</h6>
                            <p class="font-bold">{{ $class->short }}</p>
                        </div>
                    </div>
                    </a>
                    @endif
                    @endforeach 
               </div>
            </div>
        </div>

@endif     
@include('backend.pages.footer')
</main>
@stop