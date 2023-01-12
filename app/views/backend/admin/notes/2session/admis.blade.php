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
                <h3>Résultats des examens 2<sup>ème</sup> Session</h3>
                <ul>
                    <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                    <li class="divider la la-arrow-right"></li>
                    <li>{{$title}}</li>
                </ul>
                </div>
            </section>
             <!-- Actions -->            
            <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
                <a href="/admin/resultats_examen/session_2/vérification/{{$class->id.'/'.$parcour->id}}" class="btn btn_outlined btn_primary">
                    <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Retour
                </a>
                <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <span class="badge badge_outlined badge_primary  ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">Niveau: {{ $class->short }}</span>
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">Parcours: {{ $parcour->abr }}</span>
                @if($ifhaofficial > 0)
                <a href="{{URL::route('affichageAdmis2', [$class->id, $parcour->id])}}" target="_blank" class="btn btn_outlined btn_success">
                    <span class="la la-print text-xl leading-none ltr:mr-2 rtl:ml-2"></span> Admis
                </a> 
                 <a href="{{URL::route('affichageNoAdmis2', [$class->id, $parcour->id])}}" target="_blank" class="btn btn_outlined btn_danger">
                    <span class="la la-print text-xl leading-none ltr:mr-2 rtl:ml-2"></span> Non Admis
                </a>
                @endif   
                
                </div>
            </div> 
            @if($ifhaofficial > 0)
            @include('backend.admin.administration.Pay.return')
            <form method="post" action="{{ URL::current() }}">   
            <div class="card p-5 flex flex-col mt-2">
                <div class="font-bold mt-2">
                Total admis: <span class="badge badge_success">{{$admis}}</span> | Total Non admis: <span class="badge badge_danger">{{$nonadmis}}</span>
                </div>
                <table class="table table_bordered w-full mt-3">
                    <thead>
                        <tr>
                            <th class="text-center" width="20">#</th>
                            <th class="text-center" width="100">Matricule</th>
                            <th class="ltr:text-left rtl:text-right">Nom</th>
                            <th class="ltr:text-left rtl:text-right">Prénoms</th>
                            <th class="text-center" width="120">Mention</th>
                            <th class="text-center" width="100">Admis</th>
                            <th class="text-center" width="100">Ecolage</th>
                            <th class="text-center" width="130">Relevé de notes</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>  
                      @foreach($officials as $key => $result)   
                        <?php 
                            $realPay        = Pay::where('id_etudiant',             $result->id_student)
                                                            ->where('class_id',     $class->id)
                                                            ->where('parcour_id',   $parcour->id)
                                                            ->where('yearsUniv',    $result->yearsUniv)
                                                            ->sum('nbreMois'); 

                            $presents       = Credit::where('id_student',           $result->id_student)
                                                            ->where('class_id',     $class->id)
                                                            ->where('parcour_id',   $parcour->id)
                                                            ->where('status', 1)
                                                            ->where('yearsUniv',    $year->yearsUniv)
                                                            ->where('session', 2)
                                                            //->where('semestre', 1)
                                                            ->count();

                            $tests_1         = Delibera::where('class_id',               $class->id)
                                                            ->where('parcour_id',        $parcour->id)
                                                            ->where('id_student',        $result->id_student)
                                                            ->where('session', 2)
                                                            ->where('semestre', 3)
                                                            ->groupBy('id_student')
                                                            ->first();

                            $var            = $tests_1->deliberation;                                
                        ?>
                       <tr>
                            <td class="text-center">
                            @if($realPay == 10)
                            <label class="custom-checkbox">
                            <input type="checkbox" checked name="email[]" value="{{$result->stud->email}}">
                            <span></span>
                            </label>
                            @else
                            <label class="custom-checkbox">
                            <input type="checkbox" name="" value="" disabled>
                            <span></span>
                            </label>
                            @endif
                            </td>
                            <td class="text-center">
                                {{$result->stud->matricule}}
                            </td>
                            <td class="">{{$result->stud->fname}}</td>
                            <td class="">{{$result->stud->lname}}</td>
                            <?php ?>
                            <td class="text-center">
                                @if($result->moyenne >= $var && $result->moyenne <= 11.99)
                                    <span class="text-blue-700">Passable</span> 
                                    @elseif($result->moyenne >= 12 && $result->moyenne <= 13.99)
                                    <span class="text-blue-700">Assez-Bien</span> 
                                    @elseif($result->moyenne >= 14 && $result->moyenne <= 15.99) 
                                    <span class="text-green-700">Bien</span> 
                                    @elseif($result->moyenne >= 16) 
                                    <span class="text-green-700">Très-Bien</span> 
                                    @else
                                    <span class="text-red-700">Null</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($result->admis == 1) 
                                <span class="badge badge_success">Oui</span> 
                                @else 
                                <span class="badge badge_danger">Non</span> 
                                @endif
                            </td>
                             <td class="text-center">
                                @if($realPay == 10) <span class="badge badge_outlined badge_success">Reglé</span> @else <span class="badge badge_outlined badge_danger">Non reglé</span> @endif
                            </td>
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::current().'/'.rtrim(strtr(base64_encode($result->stud->id), '+/', '-_'), '=')}}/relevenote_2session" target="_blank" class="btn btn-icon btn_success">
                                  <span class="la la-file-alt text-xl"></span>
                                </a>    
                                </div>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
                <div class="omt-aut">
                    <hr class="my-4 border-dashed">
                    <div class="flex px-0 flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                    	@if(Auth::user()->is_admin)
                        @if(!Auth::user()->is_secretaire)
                        <a onclick="return confirm('Vous êtes sur cette action?')" href="{{URL::route('delete_resultS2', [$class->id, $parcour->id])}}" class="btn btn_danger uppercase">
		                    <span class="la la-trash-restore text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
		                    Restaurer
		                </a>
                        @endif @endif
                        @if($admis > 0)
                        <button onclick="return confirm('Attention! Les étudiants doivent avoir une adresse email.')" class="btn btn_primary ltr:ml-auto rtl:mr-auto"> Envoyer par email <span class="la la-send text-xl"></span></button>
                        @endif
                     </div> 
                </div>
            </div>  
         </form>
          @else
          <!-- Layout -->
          <div class="alert alert_danger">
            <strong class="uppercase"><bdi>Désolé!</bdi></strong>
             Il n'y a pas des données pour le moment.  
            <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
        </div>
        @endif          
@include('backend.pages.footer')
</main>

@stop