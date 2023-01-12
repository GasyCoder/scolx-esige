@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">
            <!-- Breadcrumb -->
            <section class="breadcrumb lg:flex items-start">
                <div class="p-8">
                <h3>Résulats des examens</h3>
                <ul>
                    <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                    <li class="divider la la-arrow-right"></li>
                    <li>{{$title}}</li>
                </ul>
                </div>
            </section>
            @if($ifhasresults > 0)
             <!-- Actions -->
            <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
                <a href="/admin/resultats_examen/session_2/officiel/{{$class->id.'/'.$parcour->id}}" class="btn btn_outlined btn_primary">
                    <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Retour
                </a>
                <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <a href="{{URL::route('affichagesprint', [$class->id, $parcour->id])}}" class="btn btn_outlined btn_secondary">
                    <span class="la la-print text-xl leading-none ltr:mr-2 rtl:ml-2"></span> Mode impression
                </a>  
                <a onclick="return confirm('Vous êtes sur cette action?')" href="{{URL::route('restore')}}" class="btn btn_danger uppercase">
                    <span class="la la-trash-restore text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Restaurer
                </a>
                </div>
            </div> 
            @include('backend.admin.administration.Pay.return')
            <div class="card p-5 flex flex-col mt-5">
                <h3>Résultats officiel de l'examen 2ème session</h3>
                <div class="font-bold mt-3">
                Total admis: <span class="badge badge_success">{{$admis}}</span> | Total A journée: <span class="badge badge_danger">{{$nonadmis}}</span>
                </div>
                <table class="table table_bordered w-full mt-3">
                    <thead>
                        <tr>
                            <th class="text-center" width="20">Rang</th>
                            <th class="text-center" width="150">Matricule</th>
                            <th class="ltr:text-left rtl:text-right">Nom</th>
                            <th class="ltr:text-left rtl:text-right">Prénoms</th>
                            <th class="text-center" width="150">Mention</th>
                            <th class="text-center" width="150">Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>  
                      @foreach($sessionstwo as $results)  
                        <tr>
                            <td class="text-center">{{$i++;}}</td>
                            <td class="text-center">{{$results->stud->matricule}}</td>
                            <td class="">{{$results->stud->fname}}</td>
                            <td class="">{{$results->stud->lname}}</td>
                            <td class="text-center">
                                @if($results->moyenne >= 10 && $results->moyenne <= 11.99)
                                    <span class="text-blue-700">Passable</span> 
                                    @elseif($results->moyenne >= 12 && $results->moyenne <= 13.99)
                                    <span class="text-blue-700">Assez-Bien</span> 
                                    @elseif($results->moyenne >= 14 && $results->moyenne <= 15.99) 
                                    <span class="text-green-700">Bien</span> 
                                    @elseif($results->moyenne >= 16) 
                                    <span class="text-green-700">Très-Bien</span> 
                                    @else
                                    <span class="text-red-700">Null</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($results->admis == 1)Admis @else <span class="text-red-700">A journée</span> @endif
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
         @else
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
                <a href="/admin/resultats_examen/session_2/officiel/{{$class->id.'/'.$parcour->id}}" class="btn btn_outlined btn_primary">
                    <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Retour
                </a>
        </div>
        </div> 
        <div class="alert alert_danger">
            <strong class="uppercase"><bdi>Désolé!</bdi></strong>
             Il n'y a pas des résultats pour le moment.  
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
                Classe
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->name }}</span>
            </a>
             <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcour
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->name }}</span>
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
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">2<sup>ème</sup></span>
            </a>
        </div>  
    </aside>
@stop