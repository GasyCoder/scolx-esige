@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>

@section('title') Resultats des examens - {{$year->yearsUniv}} @stop

@section('content')
    <main class="workspace">
@if($control->openNote > 0)         
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}} - année d'étude {{$year->yearsUniv}}</h3>
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
                 <a href="{{ URL::current().'/'.$kilasy->id}}/1">    
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
@else
    <div class="container flex items-center justify-center mb-2 py-1">
        <div class="card p-5 flex flex-col gap-y-2 w-full md:w-1/2 xl:w-1/4">
            <div class="mx-2 md:mx-3">
                <h3 class="" style="color:#DC2626"> <span class="la la-exclamation-triangle"></span>Attention!</h3>
            </div>
            <hr class="border-dashed">
                <div class="modal-body text-xl">
                    Cette page ne peut pas être ouverte avant l'inclusion de toutes les notes des étudiants!
                </div>
                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                <div class="modal-footer">
                    <div class="flex ltr:ml-auto rtl:mr-auto">
                        <a onclick="return confirm('Vous êtes vraiment sur?')" href="{{ URL::route('alertOpenX') }}" class="btn btn_primary ltr:ml-2 rtl:mr-2">Activer cette page</a>
                    </div>
                </div>
                @endif @endif
        </div>
    </div>
    @endif     
@include('backend.pages.footer')
</main>
@stop