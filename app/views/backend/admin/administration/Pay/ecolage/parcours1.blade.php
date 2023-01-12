@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Paiement - parcours @stop
@section('content')
    <main class="workspace">
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/paiement/classes" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
   @if(count($parcours) > 0)     
        <!-- List -->
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr>
                           <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Parcours</th>                
                            <th class="" style="text-align:center">Eff total étudiants</th>
                             <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parcours as $key => $parcour)
                        <tr>
                            <td class="">{{$key+1}}</td>
                            <td class="font-bold">{{ $parcour->name }}</td>
                            <td class="text-center">
                            <?php $students = Student::where('class_id', $class->id)->where('parcour_id', $parcour->id)->get();?> 
                               @if(count($students) > 0)
                               <span class="badge badge_success">{{count($students)}}</span>
                               @else
                               <span class="badge badge_outlined badge_secondary"> 0 
                               @endif   
                            </td>
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{URL::route('etudiantEcolage', [$class->id,$parcour->id])}}" class="btn btn-icon btn_primary">
                                        <span class="la la-eye"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@include('backend.pages.footer')
</main>
    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Status -->
        <h3 class="p-5">Informations</h3>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">  
        <a href="#" class="flex items-center text-normal">
          <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
            Classe
          <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"> 
            {{ $class->name }}
          </span>
        </a>
        <a href="#" class="flex items-center text-normal">
          <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
            Total parcour
          <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"> 
            {{ count($parcours)}}
          </span>
        </a>
        </div>
    </aside>
 @else
<br>
<div class="alert alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Il n'y a pas des données disponible ici. Veuillez insérer votre <b><a href="{{URL::route('indexParcour')}}" class="underline">parcours</a></b>.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif   
@stop