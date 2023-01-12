@extends('backend.main')
<?php $path = Session::get('language'); ?>
@include('backend.timeAgo')
@section('title') Ré-inscription - {{ $student->fname.' '.$student->lname.' - '.$years->yearsUniv}} @stop
@section('content') 
<!-- Workspace -->
<main class="workspace workspace_with-sidebar">
@if(count($Onenotes) > 0)  
        <!-- Header -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h1>Ré-inscription</h1>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Page</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>ré-inscription</li>
            </ul>
            </div>
        </section>
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/tous-etudiants/listes" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <button class="btn btn_outlined btn_success">
                    Année Universitaire: {{$years->yearsUniv}}
                </button>
                <a href="{{ URL::route('etudiantEdit', [$student->id,$class->id])}}" class="btn btn-icon btn_primary ltr:ml-5 rtl:mr-5"> <span class="la la-pen-fancy"></span></a>
                <a href="#" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                 <span class="la la-trash-alt"></span>
                </a>
            </div>
         
        </div>             
        <div class="grid lg:grid-cols-4 gap-5 mt-5">
            <!-- Profile Etudiants -->
            @include('backend.admin.pedagogie.reinscription.profile')
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-3">
            @if($years->yearsUniv != $student->yearsUniv)
            <div id="resultajax2" class="center"></div>
            <!-- Actions -->
            {{ Form::open(['route'=>['Uplevel', $student->id], 'files'=>'true', 'class'=>'border border-dashed p-4', 'id'=>'myForm2', 'data-toggle'=>'validator', 'style'=>'border-color:blue; background-color:#ECFEFF'])}}       
                <div class="flex flex-wrap flex-row -mx-4">
                <input type="hidden" name="yearsUniv" value="{{$years->yearsUniv}}">
                <input type="hidden" name="class_id"  value="{{$class->id}}">
                <div class="custom-select flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="fname">Observation</label>
                    <select name="admis" class="form-control">
                        @if($mysum >= 10)
                            <option value="1" selected class="font-bold text-primary">Oui Admis</option>
                        @else
                            <option value="0" selected class="font-bold text-primary">Non Admis</option>
                        @endif 
                    </select>
                </div>
                @if($mysum <= 12)
                <div class="custom-select flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="fname">Classe</label>
                    <select name="class_id" class="form-control">
                    <option value="" selected disabled>---Choisir les classes---</option>
                    @foreach($classes as $cla)
                        <option value="{{$cla->id}}">{{$cla->name}}</option>
                    @endforeach
                    </select>
                    <span>
                    @if($mysum >= 10) étudiant est  
                        @if($student->niveau->short =='AP') 
                        admis en Licence 1
                        @elseif($student->niveau->short =='L1') 
                        admis en Licence 2    
                        @elseif($student->niveau->short == 'L2')
                        admis en Licence 3 
                        @elseif($student->niveau->short =='L3')
                        admis en Master 1 
                        @elseif($student->niveau->short =='M1')
                        admis en Master 2  
                        @endif
                    @endif
                    </span>
                </div>
                @else
                <div class="custom-select flex-shrink px-4 w-full xl:w-1/2">
                    <label class="label block mb-2" for="fname">Classe</label>
                    <select name="class_id" class="form-control" disabled>
                        <option value="{{$student->niveau->id}}">{{$student->niveau->name}}</option>
                    </select>
                </div>
                @endif
                </div>
                <label class="custom-checkbox p-4">
                    <input type="checkbox" name="user_id" required="">
                    <span></span>
                    <span>Oui, je m'engage cette action.</span>
                </label>
                <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto p-4">
                    <button class="btn btn_success">
                        <span class="la la-check text-xl leading-none ltr:mr-0 rtl:ml-0"></span>
                        S'inscrire
                    </button>
                </div>
             {{ Form::close() }} 
             @include('backend.admin.pedagogie.reinscription.ajax')
             @else
             <!-- Alert -->
            <div class="p-5 flex flex-col gap-y-2">
                <div class="alert alert_success">
                    <strong class="uppercase"><bdi><span class="la la-check"></span>Succès!</bdi></strong>
                    Cet étudiant a été ré-inscrir avec succès sur cette année d'étude!
                    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
                </div>
            </div>
             @endif  
                <div class="card p-5">
                <h3>Informations</h3>
                <div class="accordion mt-0">
                    <h5 class="p-5 active" data-toggle="collapse" data-target="#accordion">
                      Vérification #1
                        <span class="collapse-indicator la la-eye text-xl"></span>
                    </h5>
                    <div id="accordion" class="collapse open">
                        <div class="p-5 pt-0">
                         <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right" width="180">Année d'étude</th>
                                <th class="text-center">Classe</th>
                                <th class="text-center">Admis</th>
                                <th class="text-center">Relevé des notes</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($Onenotes as $noty)
                            <?php $som = Note::where('id_student', $noty->id_student)
                                                ->where('yearsUniv', $noty->yearsUniv)
                                                ->groupBy('yearsUniv')
                                                ->avg('note'); 
                            ?>
                            <tr>
                            <td class="font-bold">{{$noty->yearsUniv}}</td>
                            <td class="font-bold text-center">{{$noty->niveau->short}} 
                                @if($noty->grade == 'AL') mixte @endif
                            </td>
                            <td class="font-bold text-center">
                                @if($som >= 10)<span class="badge badge_success">Oui, 
                                    @if($noty->niveau->short =='AP') 
                                    admis en L1
                                    @elseif($noty->niveau->short =='L1') 
                                    admis en L2    
                                    @elseif($noty->niveau->short == 'L2')
                                    admis en L3 
                                    @elseif($noty->niveau->short =='L3')
                                    admis en M1 
                                    @elseif($noty->niveau->short =='M1')
                                    admis en M2  
                                    @endif
                            </span> @else <span class="badge badge_danger">Non</span> @endif
                            </td>
                            <td class="text-center">
                                <div class="inline-flex">
                                @if($noty->class_id == 1)
                                <a href="{{URL::route('ReleveForAp', [$noty->id_student, $noty->class_id, $noty->yearsUniv])}}" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                  <span class="la la-file text-xl"></span>
                                </a>
                                @else
                                <a href="{{URL::route('myReleve', [$noty->id_student, $noty->class_id, $noty->yearsUniv])}}" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                  <span class="la la-file text-xl"></span>
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
                    <h5 class="border-t border-divider p-5" data-toggle="collapse" data-target="#accordion-2">
                      Vérification #2
                        <span class="collapse-indicator la la-eye text-xl"></span>
                    </h5>
                    <div id="accordion-2" class="collapse">
                    <hr class="border-dashed mt-2">
                    <div class="p-5 pt-0">
                    <h3 class="">Paiement d'écolage</h3>    
                    <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right" width="180">Année d'étude</th>
                                <th class="text-center">Mois payé</th>
                                <th class="text-center">Mois non payé</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($annee as $myYear)
                            <?php 
                            $me = Pay::where('id_etudiant', $student->id)
                                        ->where('nbreMois', '>=', 1)
                                        ->where('yearsUniv', $myYear->yearsUniv)
                                        ->sum('nbreMois'); 
                            $reste = 10-$me;
                            $payee = 10-$reste; 
                            ?>
                            <tr>
                                <td>{{$myYear->yearsUniv}}</td>
                                <td class="text-center"><span class="badge badge_success">{{$payee}} mois</span></td>
                                <td class="text-center"><span class="badge badge_danger">{{$reste}} mois</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr class="border-dashed mt-5">
                    <h3 class="">Présences et Absences</h3>
                    <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right" width="180">Année d'étude</th>
                                <th class="text-center">Présences</th>
                                <th class="text-center">Absences</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($annee as $myYear) 
                        <?php 
                            $presents = Absence::where('id_student', $student->matricule)
                                                ->where('class_id', $student->class_id)
                                                ->where('yearsUniv', $myYear->yearsUniv)
                                                ->where('status', 1)
                                                ->count();
                            $absents = Absence::where('id_student', $student->matricule)
                                                ->where('class_id', $student->class_id)
                                                ->where('yearsUniv', $myYear->yearsUniv)
                                                ->where('status', 0)
                                                ->count();
                        ?>   
                            <tr>
                                <td>{{$myYear->yearsUniv}}</td>
                                <td class="text-center"><span class="badge badge_success">{{$presents}}</span></td>
                                <td class="text-center"><span class="badge badge_danger">{{$absents}}</span></td>
                            </tr>
                        @endforeach    
                        </tbody>
                    </table>
                    <hr class="border-dashed mt-5">
                    <h3>Informations parentales</h3>
                      <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">Père</th>
                                <th class="ltr:text-left rtl:text-right">Mère</th>
                                <th class="ltr:text-left rtl:text-right">Proféssion père</th>
                                <th class="ltr:text-left rtl:text-right">Proféssion mère</th>
                                <th class="ltr:text-left rtl:text-right">Contact</th>
                                <th class="ltr:text-left rtl:text-right">Adresses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$student->papa}}</td>
                                <td>{{$student->mama}}</td>
                                <td>{{$student->jobpapa}}</td>
                                <td>{{$student->jobmama}}</td>
                                <td>{{$student->contactParent}}</td>
                                <td>{{$student->adresseParent}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                    </div>
                </div>
            </div>
            </div>           
        </div>  
@include('backend.pages.footer') 
@else
<br><br>
<div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
    <a href="/admin/tous-etudiants/listes" class="btn btn_primary">
        <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
        Retour
    </a>
</div> 
<div class="alert alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Aucun donées pour le moment! peut-être vous devez ajouter le note de cet étudiant. Merci! 
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif 
</main>
@if(count($Onenotes) > 0)
@include('backend.admin.pedagogie.reinscription.side')
@else
@endif 
@stop