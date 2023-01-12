@extends('backend.main')
<?php $path = Session::get('language'); ?>

@section('title') Gestion des paiements @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-4">
@include('backend.break')
            </div>
        </section>
       <div class="p-4">
            <div class="overflow-x-auto">
                <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5">
                 <a href="{{URL::route('pageEcolage')}}">    
                    <div class="card card_hoverable card_list" style="color:#047857">
                        <div class="image image_icon">
                            <span class="la la-money-check-alt la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Ecolage/Droit d'inscription</h5>
                            <p>Paiement</p>
                        </div>
                    </div>
                    </a>
                    <a href="">    
                    <div class="card card_hoverable card_list" style="color:#A21CAF">
                        <div class="image image_icon">
                            <span class="la la-money-bill-alt la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Autres</h5>
                            <p>Paiement</p>
                        </div>
                    </div>
                    </a>
               </div>
            </div>
        </div>
    
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
             Total
          <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"> 
             <?php $students = Student::count();?>
             {{$students}}
          </span>
        </a>
        <a href="" class="flex items-center text-normal">
          <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
           Année Universitaire
          <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"> 
             {{$year->yearsUniv}}
          </span>
        </a>
        </div>
    </aside>
@stop