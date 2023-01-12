@extends('backend.main')
<?php $path = Session::get('language'); ?>
@include('backend.timeAgo')
@section('title') Profil - {{ $profile->fname.' '.$profile->fname }} @stop
@section('content') 
    <!-- Workspace -->
<main class="workspace workspace_with-sidebar">
@include('backend.pages.alerts')   
        <!-- Header -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/tous-etudiants/listes" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <a href="{{ URL::route('etudiantEdit', [$profile->id, $class->id, $parcour->id])}}" class="btn btn-icon btn_primary ltr:ml-5 rtl:mr-5"> <span class="la la-pen-fancy"></span></a>
                <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteStudent', $profile->id)}}" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                 <span class="la la-trash-alt"></span>
                </a>
            </div>
         
        </div>             
        <div class="grid lg:grid-cols-4 gap-5 mt-5">
            <!-- Profile Etudiants -->
            
            @include('backend.admin.pedagogie.reinscription.profile')

            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-3">
                <!-- Bordered -->
                <div class="card p-5">
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
                                <td>{{$parent->papa}}</td>
                                <td>{{$parent->mama}}</td>
                                <td>{{$parent->jobpapa}}</td>
                                <td>{{$parent->jobmama}}</td>
                                <td>{{$parent->contactParent}}</td>
                                <td>{{$parent->adresseParent}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr class="border-dashed mt-5">
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
                            $me = Pay::where('id_etudiant', $profile->id)
                                        ->where('nbreMois', '>=', 1)
                                        ->where('yearsUniv', $myYear->yearsUniv)
                                        ->sum('nbreMois'); 
                            $reste = 10-$me;
                            $payee = 10-$reste; 
                            ?>
                            <tr>
                                @if($myYear->yearsUniv == $years->yearsUniv)
                                <td class="font-bold">{{$myYear->yearsUniv}}</td>
                                @else
                                <td>{{$myYear->yearsUniv}}</td>
                                @endif
                                @if($payee == 10)
                                <td class="text-center"><span class="badge badge_success">{{$payee}} mois</span>
                                </td>
                                @else
                                <td class="text-center"></td>
                                @endif
                                @if($reste == 0)
                                <td class="text-center"></td>
                                @else
                                <td class="text-center"><span class="badge badge_danger">{{$reste}} mois</span>
                                </td>
                                @endif
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
                            $presents = Absence::where('id_student', $profile->matricule)
                                                ->where('class_id',  $class->id)
                                                ->where('yearsUniv', $myYear->yearsUniv)
                                                ->where('status', 1)
                                                ->count();
                            $absents = Absence::where('id_student', $profile->matricule)
                                                ->where('class_id', $profile->class_id)
                                                ->where('yearsUniv', $myYear->yearsUniv)
                                                ->where('status', 0)
                                                ->count();
                        ?>   
                            <tr>
                                @if($myYear->yearsUniv == $years->yearsUniv)
                                <td class="font-bold">{{$myYear->yearsUniv}}</td>
                                @else
                                <td>{{$myYear->yearsUniv}}</td>
                                @endif
                                <td class="text-center"><span class="badge badge_success">{{$presents}}</span></td>
                                <td class="text-center"><span class="badge badge_danger">{{$absents}}</span></td>
                            </tr>
                        @endforeach    
                        </tbody>
                    </table>
                    <hr class="border-dashed mt-5">
                    <h3 class="">Relevé des Notes</h3>
                    <div class="overflow-x-auto"> 
                       <table class="table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                            <th class="ltr:text-left rtl:text-right" width="80">Année d'étude</th>
                            <th class="text-center" width="150">Admis</th>
                            <th class="text-center" width="150">Session</th>
                            <th class="text-center" style="text-align:center" width="110">Relevé de Notes</th>
                            </tr>
                        </thead>
                            <tbody>
                            @foreach($releves_ones as $releves_one)
                            <?php 
                                                 
                                $payer  = Pay::where('id_etudiant',   $profile->id)
                                                ->where('yearsUniv',  $releves_one->yearsUniv)
                                                ->where('class_id',   $class->id)
                                                ->where('parcour_id', $parcour->id)
                                                ->sum('nbreMois'); 

                                $reste  = 10-$payer;               
                            ?>
                                <tr>
                                    @if($releves_one->yearsUniv == $years->yearsUniv)
                                    <td class="font-bold">{{$releves_one->yearsUniv}}</td>
                                    @else
                                    <td>{{$myYear->yearsUniv}}</td>
                                    @endif
                                     <td class="font-bold text-center">
                                        @if($releves_one->admis == 1)<span class="badge badge_success">Oui</span> @else 
                                        <span class="badge badge_danger">Non</span> @endif
                                    </td>
                                    <td class="font-bold text-center">
                                        <span class="badge badge_primary">1</span>
                                    </td>
                                    @if($releves_one->session == 1)
                                    <td class="text-center">
                                        <div class="inline-flex">
                                        @if($class->id == 1)
                                        <a href="/admin/resultats_examen/session_1/version-officiel/résultats/{{$class->id}}/{{$parcour->id.'/'.rtrim(strtr(base64_encode($profile->id), '+/', '-_'), '=')}}/relevenote_semestre_1" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                          <span class="la la-file-alt text-xl"></span>
                                        </a>
                                        @else
                                        <a href="/admin/resultats_examen/session_1/version-officiel/résultats/{{$class->id}}/{{$parcour->id.'/'.rtrim(strtr(base64_encode($profile->id), '+/', '-_'), '=')}}/relevenote_semestre_1" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                          <span class="la la-file-alt text-xl"></span>
                                        </a>
                                        @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                            <hr>
                             <tbody>
                            @foreach($releves_tws as $releves_tw)
                            <?php 
                                                 
                                $payer  = Pay::where('id_etudiant',   $profile->id)
                                                ->where('yearsUniv',  $releves_tw->yearsUniv)
                                                ->where('class_id',   $class->id)
                                                ->where('parcour_id', $parcour->id)
                                                ->sum('nbreMois'); 

                                $reste  = 10-$payer;               
                            ?>
                                <tr>
                                    <td class="">{{$releves_tw->yearsUniv}}</td>
                                     <td class="font-bold text-center">
                                        @if($releves_tw->admis == 1)<span class="badge badge_success">Oui</span> @else 
                                        <span class="badge badge_danger">Non</span> @endif
                                    </td>
                                    <td class="font-bold text-center">
                                        <span class="badge badge_danger">2</span>
                                    </td>
                                    @if($releves_tw->session == 2)
                                    <td class="text-center">
                                        <div class="inline-flex">
                                        @if($class->id == 1)
                                        <a href="/admin/resultats_examen/session_2e/officiel/{{$class->id}}/{{$parcour->id.'/'.rtrim(strtr(base64_encode($profile->id), '+/', '-_'), '=')}}/relevenote_2session" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                          <span class="la la-file-alt text-xl"></span>
                                        </a>
                                        @else
                                        <a href="/admin/resultats_examen/session_2e/officiel/{{$class->id}}/{{$parcour->id.'/'.rtrim(strtr(base64_encode($profile->id), '+/', '-_'), '=')}}/relevenote_2session" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                          <span class="la la-file-alt text-xl"></span>
                                        </a>
                                        @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>           
        </div>  
@include('backend.pages.footer')  
</main>
<!--Sidebar -->
@include('backend.admin.pedagogie.reinscription.side')
@stop