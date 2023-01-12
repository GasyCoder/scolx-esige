@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') Résultats d'examen AP @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Resulats d'examen - {{$class->name}}</h3>
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
            <a href="/admin/resultats_examen/class/etudiants" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @else
            <a href="/admin/resultats_examen/class/etudiants/{{$class->id}}" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @endif
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">

            @if($class->id == 1)    
            <span class="badge badge_outlined badge_warning font-bold" style="color:#475569">
                    Classe: {{$class->name}}
            </span>
            
            @else
             <span class="badge badge_outlined badge_warning text-gray-700 font-bold" style="color:#333">
                   Parcour: {{$parcourx->name}}
            </span>
            @endif
            <a href="#" target="_blank" class="btn btn_secondary">
                    <span class="la la-print text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Mode Impression
            </a>
            </div>
        </div> 
      
@if(count($theNote) >= 1)
@include('backend.admin.administration.Pay.return')
        <div class="card p-5 mt-3">
            <div class="overflow-x-auto">
             <form method="post" action="{{ URL::current() }}">    
              <table class="table-sorter table table_bordered w-full">
                    <thead>
                        <tr>
                            <th width="2" style="text-align:center">#</th>       
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
                        $myNote = Note::where('id_student', $student->id)
                                        ->where('class_id', $student->class_id)
                                        ->get();
                        
                        $totalNote      = DB::table('notes')->where('class_id', $class->id)
                                                            ->where('id_student', $student->id)
                                                            ->orderBy('note', 'DESC')
                                                            ->sum('note');

                        
                        $moyenne        = DB::table('notes')->where('class_id', $class->id)
                                                            ->where('id_student', $student->id)
                                                            ->orderBy('note', 'DESC')
                                                            ->avg('note');
                    ?>

                        @if(count($myNote)>=1)
                        <tr>
                            <td class="text-center">
                            @if($student->mois_reste == 0)
                            <label class="custom-checkbox">
                            <input type="checkbox" checked name="send[]" value="{{$student->email}}">
                            <span></span>
                            </label>
                            @else
                            <label class="custom-checkbox">
                            <input type="checkbox" name="send[]" value="{{$student->email}}" disabled>
                            <span></span>
                            </label>
                            @endif
                            </td>
                            <td class="text-center" style="text-align:center">
                            <div class=" avatar w-5 h-5">
                                @if(!empty($student->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'center', 'width'=>'','height'=>'']) ?>
                                @elseif($student->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$student->matricule}}
                            <input type="hidden" name="id_student[]" value="{{$student->id}}">
                            </td>
                            <td class="font-bold">{{$student->fname}} {{$student->lname}}</td>
                            <td class="text-center">
                               @if($student->mois_reste == 0) <span class="badge badge_success">Reglé</span> @else <span class="badge badge_danger">Non reglé</span> @endif
                           </td>
                            <td class="font-bold text-center">{{$student->niveau->short}} @if($student->grade == 'AL')<span style="color:#4F46E5">mixte</span> @endif</td>
                            <td class="text-center">
                               @if($moyenne >= 10) <span class="badge badge_success">Oui</span> @else <span class="badge badge_danger">Non</span> @endif</span>
                           </td>
                            <td class="text-center">
                                <div class="inline-flex">
                                <a href="{{URL::route('minireleve', $class->id).'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')}}" target="_blank" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                  <span class="la la-eye text-xl"></span>
                                </a>
                                <a href="{{ URL::route('etudiantEdit', [$student->id,$class->id])}}" class="btn btn_outlined btn-icon btn_primary  ltr:ml-2 rtl:mr-2"> <span class="la la-pen-fancy"></span></a>

                                <a href="#" class="btn btn_outlined btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
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