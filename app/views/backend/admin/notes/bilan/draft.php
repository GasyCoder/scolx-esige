@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Ajouter notes des étudiants {{$class->short}} @stop
@section('content')
<style type="text/css">
input[type=number]:focus {
  background-color:#F0FDF4;
  border: 1px solid #1E40AF;
}
</style>
<main class="workspace workspace_with-sidebar">
@if(count($ues_2) > 0)    
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}} 2ème session</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            <a href="/admin/notes/2e_session/{{$class->id}}/{{$parcour->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary mt-5">
                <span class="la la-undo"></span>
            </a> 
            </div>
           <div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-5 lg:mt-0">
                <div class="flex gap-x-2">
                <div class="avatar w-16 h-16 ltr:mr-5 rtl:ml-5">
                <div class="status bg-success"></div>
                @if(!empty($student->image))
                <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'', 'width'=>'180','height'=>'80']) ?>
                @elseif($student->sexe == 1)
                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'50']) }}
                @endif
                </div>
                <div>
                <h5>{{$student->fname}} {{$student->lname}}</h5>
                <p>Niveau : {{$student->niveau->short}} | Parcour : {{$student->parcour->abr}} <br> Année Universitaire : {{$years->yearsUniv}}</p>
                </div>
                </div>
            </div>            
        </section>

        <div class="breadcrumb breadcrumb_alt p-3 mt-2"> 
        <div class="tr:ml-auto rtl:mr-auto">    
        <div class="custom-select mt-0 w-full">
                  <select name="select_student_name" id="select_student_name" onchange="goToNext(this)" class="form-control">
                    <option value="" selected disabled>--Ajouter pour les autres étudiants--</option>
                    @foreach($students as $student)
                        <option value="/admin/notes/etudiants/notes/ajouter-2e-session/{{$student->stud->class_id.'/'.$student->stud->parcour_id.'/'.rtrim(strtr(base64_encode($student->stud->id), '+/', '-_'), '=')}}">{{ $student->stud->fname }} {{ $student->stud->lname }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            </div>
        </div> 
    {{ Form::open(['route'=>['resultat2Session', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }}
       @if($dsexist > 0) 
       @else
        <div class="flex flex-wrap gap-2 items-center ltr:ml-5 rtl:mr-5">
            <div class="flex flex-wrap gap-2 ltr:mr-5 rtl:ml-5">
                <button class="btn btn_success">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span> Confirmer l'action
                </button> 
            </div>
        </div>  
        @endif
    @include('backend.admin.administration.Pay.return')
        <!-- To UE -->
            <div class="card relative p-5 mt-3">
                    @if($class->short == 'L1')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 1</h3>
                    @elseif($class->short == 'L2')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 3</h3>
                    @elseif($class->short == 'L3')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 5</h3>
                    @elseif($class->short == 'M1')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 7</h3>
                    @elseif($class->short == 'M2')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 9</h3>
                    @endif
                    <div class="accordion rounded-xl mt-0">
                        <h3 class="border-t border-divider p-2 active" data-toggle="collapse" data-target="#faqs-1-3">
                        <span class="collapse-indicator la la-arrow-circle-down"></span>
                        </h3>
                        <div id="faqs-1-3" class="collapse open">
                        <div class="p-2">
                        <table class="table table_bordered w-full mt-0">
                        <thead>
                            <tr style="color:#3F3F46">
                                <th class="ltr:text-left rtl:text-right" width="110">Code UE</th>
                                <th class="ltr:text-left rtl:text-right" width="360">Unités d'enseignement (UE)</th>
                                 <th class="text-center" width="110">Moyenne UE</th>
                                <th class="ltr:text-left rtl:text-right" width="360">Matières (EC)</th>
                                <th class="text-center" width="110">Observation</th>
                                <th class="" style="text-align:center" width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ues_1 as $ue)
                        <?php 
                            $elements    = EC::where('codeUe', $ue->codeUe)
                                                ->where('class_id', $ue->class_id)
                                                ->where('parcour_id', $ue->parcour_id)
                                                //->groupBy('codeUe')
                                                ->get();

                            $notes       = Note::where('id_student', $ue->id_student)
                                                    ->where('class_id', $ue->class_id)
                                                    ->where('parcour_id', $ue->parcour_id)
                                                    ->where('codeUe', $ue->codeUe)
                                                    ->groupBy('codeEc')
                                                    ->get();           

                            $noteEtu     = Credit::where('id_student',      $ue->id_student)
                                                    ->where('class_id',     $ue->class_id)
                                                    ->where('parcour_id',   $ue->parcour_id)
                                                    ->where('codeUe',       $ue->codeUe)
                                                    ->where('semestre', 1)
                                                    ->get();

                            $CoefPondere     = EC::where('codeUe',          $ue->codeUe)
                                                    ->where('class_id',     $ue->class_id)
                                                    ->where('parcour_id',   $ue->parcour_id)
                                                    ->groupBy('codeUe')
                                                    ->sum('coef');                           

                        ?>       
                            <tr>
                                <?php $totalPondere = 0;?>
                                @foreach($noteEtu as $note)
                                    <?php 
                                        $NotePondere   = $note->Noteponder;
                                        $totalPondere += $NotePondere;
                                    ?> 
                                @endforeach 
                                <?php $isvalide = $totalPondere/$CoefPondere ?>
                                @if($isvalide <= 9.99)
                                <td><code class="font-bold">{{$ue->codeUe}}</code></td>
                                <td class="font-bold text-primary"> 
                                {{$ue->Uename}}
                                </td>
                                <td>
                                    <table class="table_bordered" width="100%">
                                      <tr style="line-height:12px;text-align:center;">
                                        <td><span style="color:red">{{number_format($isvalide, 2, ',', '')}}</span><br></td>
                                      </tr>
                                    </table>
                                </td>
                                <td class="font-bold">
                                     <table class="no-border" width="">
                                        @foreach($notes as $noty)
                                          <tr>
                                          <td style="padding-top:0rem;padding-bottom:0rem;">{{$noty->codeEc}}: {{$noty->mat->name}}</td>
                                        <?php 
                                            $coef  = $noty->coef*20;
                                            $mynote = $noty->noteExam*$noty->coef;
                                            $valid =  $mynote/$noty->coef;
                                        ?>
                                          @if($valid >= 10)
                                          <td style="color:green;padding-top:0rem;padding-bottom:0rem;">{{$mynote}}/{{$coef}}</td>
                                          @else
                                          <td style="color:red;padding-top:0rem;padding-bottom:0rem;">{{$mynote}}/{{$coef}}</td>
                                          @endif
                                          </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="font-bold">
                                     <table class="" width="" align="center">
                                        @foreach($notes as $noty)
                                        <?php 
                                            //$coef  =  $noty->coef*20;
                                            $valid =  $noty->noteExam;
                                        ?>
                                          <tr>
                                          @if($valid >= 10)
                                          <td style="color:green;padding-top:0rem;padding-bottom:0rem;">Validé</td>
                                          @else
                                          <td style="color:red;padding-top:0rem;padding-bottom:0rem;">A journée</td>
                                          @endif
                                          </tr>
                                        @endforeach 
                                    </table>
                                </td>
                                @if($dsexist > 0)
                                <td class="font-bold">
                                    <table class="" width="">
                                        @foreach($notes as $noty)
                                        <div class="text-center">
                                        <button class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2" disabled>
                                            <span class="la la-check-circle"></span>
                                        </button>
                                        </div><br>
                                        @endforeach 
                                    </table>
                                </td>
                                @else
                                <td class="font-bold">
                                    <table class="" width="">
                                        @foreach($notes as $noty)
                                        <div class="text-center">
                                        <a href="{{ URL::route('addNoteSession_2', [$class->id, $parcour->id]).'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=').'/'.$noty->id}}" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                            <span class="la la-plus"></span>
                                        </a>
                                        </div><br>
                                        @endforeach 
                                    </table>
                                </td>
                                @endif
                            @endif    
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div>
            <br>
                <div class="card relative p-5">
                    @if($class->short == 'L1')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 2</h3>
                    @elseif($class->short == 'L2')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 4</h3>
                    @elseif($class->short == 'L3')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 6</h3>
                    @elseif($class->short == 'M1')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 8</h3>
                    @elseif($class->short == 'M2')
                    <h3 class=""><span class="la la-check-square"></span>Semestre 10</h3>
                    @endif
                    <div class="rounded-xl mt-0">
                        <div>
                        <div class="p-2">
                        <table class="table table_bordered w-full mt-0">
                        <thead>
                            <tr style="color:#3F3F46">
                                <th class="ltr:text-left rtl:text-right" width="110">Code UE</th>
                                <th class="ltr:text-left rtl:text-right" width="360">Unités d'enseignement (UE)</th>
                                 <th class="text-center" width="110">Moyenne UE</th>
                                <th class="ltr:text-left rtl:text-right" width="360">Matières (EC)</th>
                                <th class="text-center" width="110">Note EC</th>
                                <th class="" style="text-align:center" width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($ues_2 as $ue2)
                        <?php 
                            $elements    = EC::where('codeUe', $ue2->codeUe)
                                                ->where('class_id', $ue2->class_id)
                                                ->where('parcour_id', $ue2->parcour_id)
                                                //->groupBy('codeUe')
                                                ->get();

                            $notes       = Note::where('id_student', $ue2->id_student)
                                                    ->where('class_id', $ue2->class_id)
                                                    ->where('parcour_id', $ue2->parcour_id)
                                                    ->where('codeUe', $ue2->codeUe)
                                                    ->orderBy('codeEc')
                                                    ->groupBy('codeEc')
                                                    ->get();                     
                        ?>       
                            <tr>
                                <td><code class="font-bold">{{$ue2->codeUe}}</code></td>
                                <td class="font-bold text-primary"> 
                                {{$ue2->Uename}}
                                </td>
                                <td align="center" class="font-bold">
                                    {{$ue2->UEmoyenne}}
                                </td>
                                <td class="font-bold">
                                     <table class="no-border" width="">
                                        @foreach($elements as $element)
                                          <tr>
                                          <td>{{$element->name}}</td>
                                          </tr>
                                        @endforeach 
                                    </table>
                                </td>
                                <td class="font-bold">
                                     <table class="" width="" align="center">
                                        @foreach($notes as $noty)
                                          <tr>
                                          @if($noty->note >= 10)
                                          <td style="color:green">{{$noty->note}}</td>
                                          @else
                                          <td style="color:red">{{$noty->note}}</td>
                                          @endif
                                          </tr>
                                        @endforeach 
                                    </table>
                                </td>
                                @if($dsexist > 0)
                                <td class="font-bold">
                                    <table class="" width="">
                                        @foreach($notes as $noty)
                                        <div class="text-center">
                                        <button class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2" disabled>
                                            <span class="la la-check-circle"></span>
                                        </button>
                                        </div><br>
                                        @endforeach 
                                    </table>
                                </td>
                                @else
                                <td class="font-bold">
                                    <table class="" width="">
                                        @foreach($notes as $noty)
                                        <div class="text-center">
                                        <a href="{{ URL::route('addNoteSession_2', [$class->id, $parcour->id]).'/'.rtrim(strtr(base64_encode($noty->stud->id), '+/', '-_'), '=').'/'.$noty->id}}" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                            <span class="la la-plus"></span>
                                        </a>
                                        </div><br>
                                        @endforeach 
                                    </table>
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

 <table class="table table_bordered w-full" style="display:none;">
                    <tbody>
                    @foreach($noteStuds as $hello)
                        <?php 
                                                    
                            $coefdiv        = EC::where('codeUe',               $hello->codeUe)
                                                        ->where('class_id',     $student->class_id)
                                                        ->where('parcour_id',   $student->parcour_id)
                                                        ->groupBy('codeUe')
                                                        ->sum('coef'); 

                            $ues            = UE::where('codeUe',               $hello->codeUe)
                                                         ->where('class_id',    $student->class_id)
                                                         ->where('parcour_id',  $student->parcour_id)
                                                         ->groupBy('name')
                                                         ->first();                           
              
                            $myhellow       = Note::where('class_id',           $student->class_id)
                                                        ->where('parcour_id',   $student->parcour_id)
                                                        ->where('id_student',   $student->id)
                                                        ->where('codeUe',       $hello->codeUe)
                                                        ->groupBy('codeEc')
                                                        ->get(); 
                        ?> 
                        <tr>
                           <td>
                            <?php
                                $totalPondere   = 0;    
                            ?>
                           <table style="display:none">
                                @foreach($myhellow as $myhello)
                                <?php
                                    $coeficient             = EC::where('id', $myhello->element_id)->first();
                                    $NotePondere            = $myhello->note*$coeficient->coef; 
                                    $totalPondere           += $NotePondere;
                                ?>
                                @endforeach   
                           </table> 
                           </td>
                            <td>    
                            <table class="table_bordered" width="100%">   
                                <input type="text" name="id_student[]" value="{{$hello->stud->id}}">   
   
                                <input type="text" name="yearsUniv[]" value="{{$student->yearsUniv}}"> 
                           
                                <input type="text" name="class_id[]" value="{{$student->class_id}}"> 
                           
                                <input type="text" name="parcour_id[]" value="{{$student->parcour_id}}">
                            
                                <input type="text" name="grade[]" value="{{$student->grade}}">
                            </table>
                            </td>
                            <td>
                            <?php $validate =  $totalPondere/$coefdiv; ?>    
                            <table class="table_bordered" width="100%">
                                @if($validate <= 9.99)   
                                    <input type="text" name="valide[]" value="0">
                                @elseif($validate >= 10)
                                    <input type="text" name="valide[]" value="1">
                                @endif
                            </table>
                            </td>
                            <td>    
                            <table class="table_bordered" width="100%">   
                                <input type="text" name="codeUe[]" value="{{$ues->codeUe}}">
                                <input type="text" name="Uename[]" value="{{$ues->name}}">
                                <input type="text" name="totalmax[]" value="{{$totalPondere}}">
                                <input type="text" name="UEmoyenne[]" value="{{number_format($validate, 2, ',', '')}}">
                            </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 {{ Form::close() }}

     @else
              <!-- Actions -->
    <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/notes_2/etudiants/{{$class->id}}/{{$parcour->id}}/2e-session" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
    </div> 
    <br>
        <div class="alert alert_danger">
        <strong class="uppercase"><bdi>Désolé!</bdi></strong>
         Il n'y a pas de résultat d'examen disponible ici pour le moment.  
        <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
        </div>
    @endif

    @include('backend.pages.footer')
    @section('js')
    <script type="text/javascript">
     var urlmenu = document.getElementById( 'select_student_name' );
     urlmenu.onchange = function() {
          window.open( this.options[ this.selectedIndex ].value, '_self');
     };
    </script>
    <script type="text/javascript">
     $('#select_student_name').select2();
    </script>
    @endsection
    </main>
    @stop