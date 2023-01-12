@extends('backend.main')
<?php $path = Session::get('language'); $control = Control::find(1);?>
@section('title') Notes 2e Session - S_2 @stop
@section('content')
<style type="text/css">
input[type=number]:focus {
  background-color:#F0FDF4;
  border: 1px solid #1E40AF;
}
</style>
<main class="workspace workspace_with-sidebar">  
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
                        @if($student->moyenne < 10)
                            <option value="/admin/notes/etudiants/notes/ajouter-2e-session/{{$student->stud->class_id.'/'.$student->stud->parcour_id.'/2/'.rtrim(strtr(base64_encode($student->stud->id), '+/', '-_'), '=')}}">
                                {{ $student->stud->fname }} 
                                {{ $student->stud->lname }}
                            </option>
                        @endif
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            </div>
        </div> 
    {{ Form::open(['route'=>['resultat2Session_2', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }}
        <div class="flex flex-wrap gap-2 items-center ltr:ml-5 rtl:mr-5">
            <div class="flex flex-wrap gap-2 ltr:mr-5 rtl:ml-5">
                <button class="btn btn_success" onclick="return confirm('Vous êtes sur cette action?')">
                    <span class="la la-check-square text-xl leading-none ltr:mr-2 rtl:ml-2"></span> Confirmer l'action
                </button> 
            </div>
        </div>  
    @include('backend.pages.alerts')
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
                                <th class="ltr:text-left rtl:text-right" width="360">Unités d'enseignement (UE)</th>
                                <!--<th class="text-center" width="110">Moyenne UE</th>-->
                                <th class="ltr:text-left rtl:text-right" width="360">Matières (EC)</th>
                                <th class="text-center" width="110">Observation</th>
                                <th class="" style="text-align:center" width="110">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ues_2 as $ue)
                        <?php 
                             $elements    = EC::where('codeUe',              $ue->codeUe)
                                                    ->where('class_id',     $class->id)
                                                    ->where('parcour_id',   $parcour->id)
                                                    ->get();

                            $unite      = UE::where('codeUe',               $ue->codeUe)
                                                    ->where('class_id',     $class->id)
                                                    ->where('parcour_id',   $parcour->id)
                                                    ->first();

                            $notes       = Note::where('id_student',        $ue->id_student)
                                                    ->where('class_id',     $class->id)
                                                    ->where('parcour_id',   $parcour->id)
                                                    ->where('codeUe',       $ue->codeUe)
                                                    ->where('semestre', 2)
                                                    ->groupBy('codeEc')
                                                    ->get();           

                            $noteponder     = Credit::where('id_student',   $ue->id_student)
                                                    ->where('class_id',     $class->id)
                                                    ->where('parcour_id',   $parcour->id)
                                                    ->where('codeUe',       $ue->codeUe)
                                                    ->where('semestre', 2)
                                                    ->sum('Noteponder');

                            $CoefPondere  = EC::where('codeUe',             $ue->codeUe)
                                                    ->where('class_id',     $class->id)
                                                    ->where('parcour_id',   $parcour->id)
                                                    ->groupBy('codeUe')
                                                    ->sum('coef');                           

                        ?>       
                            <tr>
                                <?php $moyenneUE = $noteponder/$CoefPondere ?>
                                
                                @if($moyenneUE <= 9.99)
                                 <td class="font-bold text-primary"> 
                                    <code class="font-bold">{{$ue->codeUe}}</code>: {{$unite->name}}
                                </td>
                                <td class="font-bold">
                                     <table class="no-border" width="">
                                        @foreach($notes as $noty)
                                          <tr>
                                        <?php 
                                            $coefmax    = $noty->coef*20;
                                            $coef       = $noty->coef;
                                            $Examnote   = $noty->noteExam*$coef;
                                            $valid      = $Examnote/$coef;
                                        ?>
                                          @if($valid >= 10)

                                          <td style="padding-top:0.3rem;padding-bottom:0.3rem;color:#9bc99b;">{{$noty->codeEc}}: {{$noty->mat->name}}
                                          </td>

                                          <td style="color:#9bc99b;padding-top:0.3rem;padding-bottom:0.3rem;">{{number_format($Examnote, 2, ',', '')}}/{{$coefmax}}
                                          </td>

                                          @else
                                          <td style="padding-top:0.3rem;padding-bottom:0.3rem;">{{$noty->codeEc}}: {{$noty->mat->name}}</td>
                                          <td style="color:red;padding-top:0.3rem;padding-bottom:0.3rem;">{{number_format($Examnote, 2, ',', '')}}/{{$coefmax}}</td>
                                          @endif
                                          </tr>
                                        @endforeach
                                    </table>
                                </td>
                                 <td class="font-bold">
                                    <table class="" width="" align="center">
                                    @foreach($notes as $noty)
                                        <?php 
                                            $coefmax    = $noty->coef*20;
                                            $coef       = $noty->coef;
                                            $Examnote   = $noty->noteExam*$coef;
                                            $valid      = $Examnote/$coef;
                                        ?>
                                      <tr>
                                      @if($valid >= 10)
                                      <td style="color:#96c796;padding-top:0.3rem;padding-bottom:0.3rem;"><span class="la la-check-circle"></span> Validé</td>
                                      @else
                                      <td style="color:red;padding-top:0.3rem;padding-bottom:0.3rem;">A journée</td>
                                      @endif
                                      </tr>
                                    @endforeach 
                                    </table>
                                </td>

                                <td class="text-center">
                                    @foreach($notes as $noty)
                                    <?php 
                                        $coefmax    = $noty->coef*20;
                                        $coef       = $noty->coef;
                                        $Examnote   = $noty->noteExam*$coef;
                                        $valid      = $Examnote/$coef;
                                    ?>
                                    <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                   
                                    <a href="{{ URL::route('addNoteSession_2', [$class->id, $parcour->id]).'/'.rtrim(strtr(base64_encode($noty->stud->id), '+/', '-_'), '=').'/'.$noty->id}}" class="badge badge_primary ltr:ml-2 rtl:mr-2 mt-2">
                                      <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span> Ouvrir
                                    </a>
                                 
                                    </div>
                                    @endforeach
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
                    @foreach($noteStuds as $noteStud)
                        <?php 
                                                    
                            $coefdiv        = EC::where('codeUe',               $noteStud->codeUe)
                                                        ->where('class_id',     $student->class_id)
                                                        ->where('parcour_id',   $student->parcour_id)
                                                        ->groupBy('codeUe')
                                                        ->sum('coef'); 

                            $ues            = UE::where('codeUe',               $noteStud->codeUe)
                                                         ->where('class_id',    $student->class_id)
                                                         ->where('parcour_id',  $student->parcour_id)
                                                         ->groupBy('name')
                                                         ->first();                           
              
                            $mynotes       = Note::where('class_id',           $student->class_id)
                                                        ->where('parcour_id',   $student->parcour_id)
                                                        ->where('id_student',   $noteStud->id_student)
                                                        ->where('codeUe',       $noteStud->codeUe)
                                                        ->where('codeEc',       $noteStud->codeEc)
                                                        ->where('semestre', 2)
                                                        ->groupBy('id_student')
                                                        ->get(); 

                            $ponder         = Credit::where('id_student',       $noteStud->id_student)
                                                        ->where('class_id',     $noteStud->class_id)
                                                        ->where('parcour_id',   $noteStud->parcour_id)
                                                        ->where('codeUe',       $noteStud->codeUe)
                                                        ->where('semestre', 2)
                                                        ->where('session', 1)
                                                        ->sum('Noteponder');

                            $Coefe          = EC::where('codeUe',               $noteStud->codeUe)
                                                        ->where('class_id',     $noteStud->class_id)
                                                        ->where('parcour_id',   $noteStud->parcour_id)
                                                        ->groupBy('codeUe')
                                                        ->sum('coef');

                        ?> 
                        <tr>
                           <td>
                            <?php $Somue = $ponder/$Coefe ?>
                           <table style="display:"> 
                            @if($Somue >= 10)
                            @else
                                @foreach($mynotes as $mynote)
                                <?php
                                    //$coeficient             = EC::where('id', $myhello->element_id)->first();
                                    $note     = $mynote->noteExam;
                                    $pondere  = $note*$mynote->coef; 
                                ?>
                                @endforeach   
                            @endif
                           </table> 
                           </td>
                            <td>    
                            <table class="table_bordered" width="100%">   
                                <input type="hidden" name="id_student[]" value="{{$noteStud->stud->id}}" class="form-control"> 
                                <input type="hidden" name="class_id[]" value="{{$student->class_id}}" class="form-control">
                                <input type="hidden" name="parcour_id[]" value="{{$student->parcour_id}}" class="form-control">
                                <input type="hidden" name="yearsUniv[]" value="{{$student->yearsUniv}}" class="form-control"> 
                                <input type="hidden" name="grade[]" value="{{$student->grade}}" class="form-control">
                            
                                <input type="text" name="codeUe[]" value="{{$noteStud->codeUe}}" class="form-control">
                                <input type="text" name="Uename[]" value="{{$noteStud->Uename}}" class="form-control">
                                <input type="text" name="codeEc[]" value="{{$noteStud->codeEc}}" class="form-control">
                                <input type="text" name="Ecname[]" value="{{$noteStud->Ecname}}" class="form-control font-bold">
                                <input type="text" name="coef[]" value="{{$noteStud->coef}}" class="form-control">
                                @if($Somue >= 10)
                                <input type="text" name="NoteEc[]" value="{{$noteStud->NoteEc}}" class="form-control">
                                <input type="text" name="Noteponder[]" value="{{$noteStud->Noteponder}}" class="form-control">
                                @else
                                <input type="text" name="NoteEc[]" value="{{$note}}" class="form-control">
                                <input type="text" name="Noteponder[]" value="{{$pondere}}" class="form-control">
                                @endif
                            </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 {{ Form::close() }}
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