@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Certificat de scolarité @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-4">
        <!-- Breadcrumb -->
            <h3><i class="la la-certificate"></i>{{$title}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Choisir la classe</li>
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
                 <a href="{{ URL::current().'/'.$class->id }}">    
                    <div class="card card_hoverable card_list">
                        <div class="image image_icon">
                            <span class="la la-user-graduate la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>{{ $class->name }}</h5>
                            <p>{{ $class->short }}</p>
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
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Toggler - Mobile -->
            <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
            <!-- Status -->
            <h3 class="p-5">Les étudiants</h3>
            <hr>
            <div class="flex flex-col gap-y-5 p-5">  
            <a href="" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
              Année d'étude
              <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"> 
               {{$year->yearsUniv}}
              </span>
            </a>
            </div>
        </aside>
    @stop