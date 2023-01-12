@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}-{{$class->short}}@stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Résultats d'examen - {{$class->name}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            @if($class->id == 1)
            <a href="/admin/resultats_examen/class/etudiants" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @else
            <a href="/admin/resultats_examen/class/etudiants/{{$class->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @endif
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
            <button class="btn btn_outlined btn_success">
                    Année Universitaire: {{$year->yearsUniv}} 
            </button>    
            @if($class->id >= 2)    
             <span class="badge badge_outlined badge_warning text-gray-700 font-bold" style="color:#333">
                   Parcours: {{$parcourx->name}}
            </span>
            @endif
            </div>
        </div> 
      
@if(count($thesNotes) >= 1)
@include('backend.admin.administration.Pay.return')
        <div class="card p-5 mt-3">
            <div class="overflow-x-auto">
             <form method="post" action="{{ URL::current() }}">    
              <table class="table-sorter table table_bordered w-full">
                    <thead>
                        <tr>
                            <th width="2" style="text-align:center">Cocher</th>       
                            <th class="" width="10" style="text-align:center">Photo</th>
                            <th class="ltr:text-left rtl:text-right" width="10">Matricule</th>
                            <th class="ltr:text-left rtl:text-right" width="350">Nom complet</th>
                            <th class="text-center" style="text-align:center" width="110">Ecolage</th>
                            <th class="" style="text-align:center" width="110">Classe </th>     
                            <th class="text-center" style="text-align:center" width="110">Admis</th>
                            <th class="text-center" style="text-align:center" width="110">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                    <?php 
                        $varNote      = Note::where('id_student', $student->id)              
                                                            ->where('class_id', $class->id)
                                                            ->where('parcour_id', $parcourx->id)
                                                            ->where('yearsUniv', $year->yearsUniv)
                                                            ->orderBy('note', 'desc')
                                                            ->groupBy('id_student')
                                                            ->first();

                        $NoteExist         = Note::where('id_student', $student->id)
                                                ->where('class_id', $student->class_id)
                                                ->count();
                        
                        $totalNote      = DB::table('notes')->where('class_id', $class->id)
                                                            ->where('id_student', $student->id)
                                                            ->orderBy('note', 'desc')
                                                            ->sum('note');

                        $moyenne        = DB::table('notes')->where('class_id', $class->id)
                                                            ->where('id_student', $student->id)
                                                            ->orderBy('note', 'desc')
                                                            ->avg('note');

                        $own            = Student::where('id', $student->id)
                                                            ->where('class_id', $student->class_id)
                                                            ->where('parcour_id', $student->parcour_id)
                                                            ->where('email', $student->email)
                                                            ->first(); 

                        $realPay        = Pay::where('id_etudiant', $student->id)
                                                ->where('class_id', $student->class_id)
                                                ->where('parcour_id', $student->parcour_id)
                                                ->where('yearsUniv',  $year->yearsUniv)
                                                ->sum('nbreMois');
                    ?>

                        @if($NoteExist > 0)
                        <tr>
                            <td class="text-center">
                            @if($realPay == 10)
                            <label class="custom-checkbox">
                            <input type="checkbox" checked name="email[]" value="{{$own->email}}">
                            <span></span>
                            </label>
                            @else
                            <label class="custom-checkbox">
                            <input type="checkbox" name="" value="" disabled>
                            <span></span>
                            </label>
                            @endif
                            </td>

                            <td class="text-center" style="text-align:center">
                            <div class=" avatar w-5 h-5">
                                @if(!empty($own->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$own->image.'', '', ['class'=>'center', 'width'=>'','height'=>'']) ?>
                                @elseif($own->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$own->matricule}}
                            <input type="hidden" name="id_student[]" value="{{$own->id}}">
                            </td>
                            <td class="font-bold">{{$own->fname}} {{$own->lname}}</td>
                            <td class="text-center">
                               @if($realPay == 10) <span class="badge badge_success">Reglé</span> @else <span class="badge badge_danger">Non reglé</span> @endif
                           </td>
                            <td class="font-bold text-center">{{$varNote->niveau->short}} @if($varNote->grade == 'AL')<span style="color:#4F46E5">mixte</span> @endif</td>
                            
                            <td class="text-center">
                               @if($moyenne >= 10) <span class="badge badge_success">Oui</span> @else <span class="badge badge_danger">Non</span> @endif</span>
                           </td>
                            <td class="text-center">
                                <div class="inline-flex">
                                @if($class->id == 1)
                                <a href="{{URL::route('pureAp', $varNote->class_id).'/'.rtrim(strtr(base64_encode($varNote->id_student), '+/', '-_'), '=')}}" target="_blank" class="btn btn_outlined btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                  <span class="la la-eye text-xl"></span>
                                </a>
                                @else
                                <a href="{{URL::route('minireleve', $varNote->class_id).'/'.rtrim(strtr(base64_encode($varNote->id_student), '+/', '-_'), '=')}}" target="_blank" class="btn btn_outlined btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                  <span class="la la-eye text-xl"></span>
                                </a>
                                @endif
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <a href="#" class="btn btn_outlined btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                                @endif @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        @if($class->id == 1)
                        @foreach($libres as $mix)
                        <?php
                        $IfExist    = Note::where('id_student', $mix->id)
                                                ->where('class_id', $mix->class_id)
                                                ->count();

                        $myMixed      = Note::where('id_student', $mix->id)              
                                                            ->where('class_id', $class->id)
                                                            ->where('parcour_id', $parcourx->id)
                                                            ->where('yearsUniv', $year->yearsUniv)
                                                            ->orderBy('note', 'desc')
                                                            ->groupBy('id_student')
                                                            ->first();
                        
                        $totalNote      = DB::table('notes')->where('class_id', $class->id)
                                                            ->where('id_student', $mix->id)
                                                            ->orderBy('note', 'desc')
                                                            ->sum('note');

                        
                        $moyenne        = DB::table('notes')->where('class_id', $class->id)
                                                            ->where('id_student', $mix->id)
                                                            ->orderBy('note', 'desc')
                                                            ->avg('note');

                        $soPay          = Pay::where('id_etudiant', $mix->id)
                                                ->where('class_id', $class->id)
                                                ->where('parcour_id', $parcourx->id)
                                                ->where('yearsUniv',  $year->yearsUniv)
                                                ->sum('nbreMois');                                    
                        ?>
                        @if($IfExist > 0)
                        <tr>
                            <td class="text-center">
                            @if($soPay == 10)
                            <label class="custom-checkbox">
                            <input type="checkbox" checked name="send[]" value="{{$mix->email}}">
                            <span></span>
                            </label>
                            @else
                            <label class="custom-checkbox">
                            <input type="checkbox" name="send[]" value="{{$mix->email}}" disabled>
                            <span></span>
                            </label>
                            @endif
                            </td>
                            <td class="text-center" style="text-align:center">
                            <div class=" avatar w-5 h-5">
                                @if(!empty($mix->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$mix->image.'', '', ['class'=>'center', 'width'=>'','height'=>'']) ?>
                                @elseif($mix->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$mix->matricule}}
                            <input type="hidden" name="id_student[]" value="{{$mix->id}}">
                            </td>
                            <td class="font-bold">{{$mix->fname}} {{$mix->lname}}</td>
                            <td class="text-center">
                               @if($soPay == 10) <span class="badge badge_success">Reglé</span> @else <span class="badge badge_danger">Non reglé</span> @endif
                            </td>
                            <td class="font-bold text-center">{{$myMixed->niveau->short}} mixte</span></td>
                            <td class="text-center">
                               @if($moyenne >= 10) <span class="badge badge_success">Oui</span> @else <span class="badge badge_danger">Non</span> @endif</span>
                           </td>
                            <td class="text-center">
                                <div class="inline-flex">
                                <a href="{{URL::route('pureAp', $myMixed->class_id).'/'.rtrim(strtr(base64_encode($mix->id), '+/', '-_'), '=')}}" target="_blank" class="btn btn_outlined btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                  <span class="la la-eye text-xl"></span>
                                </a>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <a href="#" class="btn btn_outlined btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                                @endif @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="omt-aut">
                    <hr class="my-4 border-dashed">
                    <div class="flex px-0 flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                        <button class="btn btn_primary ltr:ml-auto rtl:mr-auto"> Envoyer par email <span class="la la-send text-xl"></span></button>
                     </div>   
                </div>
            </form>  
            </div>
        </div>
@else
<br>
<div class="alert alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Il n'y a pas de résultat d'examen disponible ici pour le moment.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif     
@include('backend.pages.footer')
</main>
@stop