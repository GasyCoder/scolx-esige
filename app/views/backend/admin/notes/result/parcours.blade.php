@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Résultats d'examen par Parcours @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Choisir parcours</li>
            </ul>
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/resultats_examen" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
        @if( count($parcours) > 0)
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                           <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Liste des parcours</th>              
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($parcours as $key=> $parcour)
                    <?php
                    $year   = Year::where('status', true)->first(); 
                    $filter = Note::where('parcour_id', $parcour->id)
                                        ->where('yearsUniv', $year->yearsUniv)
                                        ->count(); 
                    ?>
                        <tr>
                           <td>{{$key+1 }}</td>
                            @if($filter == false)
                             <td class="">
                              {{$parcour->name }}
                             </td>
                            @else
                             <td class="font-bold">
                              <a href="{{ URL::current().'/'.$parcour->id}}">{{$parcour->name }}</a> 
                             </td>
                            @endif
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                @if($filter == false)
                                <button class="badge badge_danger">
                                    <span class="la la-eye-slash text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Aucun résultats
                                </button>
                                @else
                                <a href="{{ URL::current().'/'.$parcour->id}}" class="badge badge_success" style="color:#fff">
                                    <span class="la la-cog text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Traitements
                                </a>
                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
     @else
  <!-- Layout -->
  <div class="alert alert_primary">
    <strong class="uppercase"><bdi>Désolé!</bdi></strong>
     Il n'y a pas des <u><a href="{{URL::route('indexEc')}}" style="color:#EF4444">parcours</a></u> sur ces classe.  
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif
@include('backend.pages.footer')
</main>
  <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tags -->
        <h2 class="p-5">Objets sélectionnés</h2>
        <hr>
         <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Niveau
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->name }}</span>
            </a>
        </div>
        <hr class="border-dashed">
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Année Universitaire
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$year->yearsUniv}}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Session
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">1<sup>ère</sup></span>
            </a>
        </div>  
    </aside>
@stop