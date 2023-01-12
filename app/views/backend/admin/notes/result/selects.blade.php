@extends('backend.main')
<?php 
$path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">      
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Générer résultats d'examen</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/resultats_examen/{{$class->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
            <button class="btn btn_outlined btn_success">
                    Année Universitaire: {{$year->yearsUniv}} 
            </button>    
            </div>
        </div>         
        @include('backend.admin.administration.Pay.return')
        <div class="grid lg:grid-cols-2 gap-5">
            <!-- Style 1 -->
            <div>
            <div class="border card mt-0 p-5">
           <h3 class="underline"><u>Session 1</u>
            (@if($class->short == 'L1')
            <th class="ltr:text-left rtl:text-right" width="80">Semestre 1 - Semestre 2</th>
            @elseif($class->short == 'L2')
            <th class="ltr:text-left rtl:text-right" width="80">Semestre 3 - Semestre 4</th>
            @elseif($class->short == 'L3')
            <th class="ltr:text-left rtl:text-right" width="80">Semestre 5 - Semestre 6</th>
            @elseif($class->short == 'M1')
            <th class="ltr:text-left rtl:text-right" width="80">Semestre 7 - Semestre 7</th>
            @elseif($class->short == 'M2')
            <th class="ltr:text-left rtl:text-right" width="80">Semestre 9 - Semestre 8</th>
            @endif)
            </h3>
            @include('backend.admin.notes.result.resultats_final')
            <hr class="">
            {{ Form::open(['route'=>['confirmSemestre_1', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap mt-5', 'id'=>'', 'data-toggle'=>''])  }}
            <table class="table table_bordered w-full" style="display:none;">
                    <tbody>   
                    @foreach($notes_1 as $hello)
                    <?php 
                        $myexams        = Note::where('class_id',               $class->id)
                                                        ->where('parcour_id',   $parcour->id)
                                                        ->where('id_student',   $hello->id_student)
                                                        ->where('codeUe',       $hello->codeUe)
                                                        ->where('codeEc',       $hello->codeEc)
                                                        ->where('semestre', 1)
                                                        ->where('status', 1)
                                                        ->where('session', 1)
                                                        ->groupBy('codeEc')
                                                        //->orderBy('id', 'desc')
                                                        ->get();                             

                        $notescc        = Notecc::where('class_id',             $class->id)
                                                        ->where('parcour_id',   $parcour->id)
                                                        ->where('id_student',   $hello->id_student)
                                                        ->where('codeUe',       $hello->codeUe)
                                                        ->where('codeEc',       $hello->codeEc)
                                                        ->where('semestre', 1)
                                                        ->where('session', 1)
                                                        ->groupBy('codeEc')
                                                        ->orderBy('id', 'desc')
                                                        ->get();
                    ?>

                        @foreach($notescc as $notecc)
                        <?php   $totalcc = ($notecc->notecc1 + $notecc->notecc2)/2;?>
                        @endforeach
                        @foreach($myexams as $myexam)
                        <?php
                                $coef                   = $myexam->coef;                               
                                $examNote               = ($myexam->noteExam)*2;
                                $Notetotalexam          = ($totalcc+$examNote)/3;
                                $TotalNote              = $Notetotalexam*$coef;
                        ?>
                        @endforeach
                        <tr>
                        <td>  
                        <table class="table_bordered" width="100%">
                            <input type="text" name="codeUe[]" value="{{$myexam->unite->codeUe}}" class="form-control">
                            <input type="text" name="codeEc[]" value="{{$myexam->codeEc}}"     class="form-control">
                            <input type="text" name="id_student[]" value="{{$hello->id_student}}" class="form-control">
                            <input type="text" name="class_id[]" value="{{$class->id}}" class="form-control"> 
                            <input type="text" name="parcour_id[]" value="{{$parcour->id}}" class="form-control">
                            <input type="text" name="yearsUniv[]" value="{{$myexam->yearsUniv}}" class="form-control">
                            <input type="text" name="NoteEc[]" value="{{number_format($Notetotalexam, 2, '.', '')}}" class="form-control">
                            <input type="text" name="coef[]" value="{{$coef}}" class="form-control">  
                            <input type="text" name="Noteponder[]" value="{{number_format($TotalNote, 2, '.', '')}}" class="form-control"> 
                        </table> 
                        </td>
                        </tr>      
                    @endforeach 
                  </tbody>
                </table>
                @if($s1existe > 0)
                   <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                     <a href="{{URL::route('resultats_semestre_1', [$class->id, $parcour->id])}}">   
                        <div class="card card_hoverable card_list">
                                @if($existeS1 > 0)
                                <div class="image image_icon" style="color:green;"> 
                                    <span class="la la-check la-4x"></span>
                                 </div>   
                                @else
                                <div class="image image_icon" style="color:green;"> 
                                    <span class="la la-file-alt la-4x"></span>
                                </div>
                                @endif
                            
                            <div class="body" style="color:">
                                <h5>Notes 1<sup>er</sup> semestre - <small>afficher</small></h5>
                            </div>
                        </div>
                      </a>
                   </div>
                @else
                <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                     <button>    
                        <div class="card card_hoverable card_list" style="color:#4F46E5">
                            <div class="image image_icon">
                                <span class="la la-file-alt la-4x"></span>
                            </div>
                            <div class="body">
                                <h5>Notes 1<sup>er</sup> semestre - <small>pour vérification</small></h5>
                            </div>
                        </div>
                    </button>
                   </div>
                @endif   
            {{ Form::close() }}

            <br>
            {{ Form::open(['route'=>['confirmSemestre_2', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }}
             <table class="table table_bordered w-full" style="display:none;">
                    <tbody> 
                    @foreach($notes_2 as $note)
                    <?php 
                            $exams        = Note::where('class_id',             $class->id)
                                                        ->where('parcour_id',   $parcour->id)
                                                        ->where('id_student',   $note->id_student)
                                                        ->where('codeUe',       $note->codeUe)
                                                        ->where('codeEc',       $note->codeEc)
                                                        ->where('semestre', 2)
                                                        ->where('session', 1)
                                                        ->where('status', 1)
                                                        ->groupBy('codeEc')
                                                        ->get();                             

                            $mynotescc        = Notecc::where('class_id',       $class->id)
                                                        ->where('parcour_id',   $parcour->id)
                                                        ->where('id_student',   $note->id_student)
                                                        ->where('codeUe',       $note->codeUe)
                                                        ->where('codeEc',       $note->codeEc)
                                                        ->where('semestre', 2)
                                                        ->where('session', 1)
                                                        ->groupBy('codeEc')
                                                        ->orderBy('id', 'desc')
                                                        ->get();
                        ?> 

                            @foreach($mynotescc as $notecc)
                            <?php $totalcc = ($notecc->notecc1 + $notecc->notecc2)/2; ?>
                            @endforeach   
                            @foreach($exams as $exam)
                            <?php
                                $coef                   = $exam->coef;                               
                                $examNote               = ($exam->noteExam)*2;
                                $Notexam                = ($totalcc+$examNote)/3;
                                $Totalnote              = $Notexam*$coef;
                            ?>
                            @endforeach   
                        <tr>
                            <td>  
                            <table class="table_bordered" width="100%">
                            <input type="text" name="codeUe[]"      value="{{$exam->unite->codeUe}}" class="form-control">
                            <input type="text" name="codeEc[]"      value="{{$exam->codeEc}}" class="form-control">
                            <input type="text" name="id_student[]"  value="{{$note->id_student}}" class="form-control">
                            <input type="text" name="class_id[]"    value="{{$class->id}}" class="form-control"> 
                            <input type="text" name="parcour_id[]"  value="{{$parcour->id}}" class="form-control">
                            <input type="text" name="yearsUniv[]"   value="{{$exam->yearsUniv}}" class="form-control">
                            <input type="text" name="NoteEc[]"      value="{{number_format($Notexam, 2, '.', '')}}" class="form-control">
                            <input type="text" name="coef[]"        value="{{$coef}}" class="form-control">  
                            <input type="text" name="Noteponder[]"  value="{{number_format($Totalnote, 2, '.', '')}}" class="form-control"> 
                            </table> 
                            </td>
                        </tr>  
                    @endforeach   
                </table>
                @if($s2existe > 0)
                  <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5" style="display:">
                    <a href="{{URL::route('resultats_semestre_2', [$class->id, $parcour->id])}}">      
                        <div class="card card_hoverable card_list">
                            <div class="image image_icon" style="color:green;">
                                @if($existeS2 > 0)
                                <div class="image image_icon" style="color:green;"> 
                                    <span class="la la-check la-4x"></span>
                                 </div>   
                                @else
                                <div class="image image_icon" style="color:green;"> 
                                    <span class="la la-file-alt la-4x"></span>
                                </div>
                                @endif
                            </div>
                            <div class="body" style="color:">
                                <h5>Notes 2ème semestre - <small>afficher</small></h5>
                            </div>
                        </div>
                    </a>
                   </div>
                @else
                @if(count($notes_2)> 0)
                <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                     <button>    
                        <div class="card card_hoverable card_list" style="color:#4F46E5">
                            <div class="image image_icon">
                                <span class="la la-file-alt la-4x"></span>
                            </div>
                            <div class="body">
                                <h5>Notes 2ème semestre - <small>pour vérification</small></h5>
                            </div>
                        </div>
                    </button>
                   </div>
                   @endif
                @endif
            {{ Form::close() }}
            </div>
            </div>
         @if(count($deuxieme_sessions) > 0)   
            @include('backend.admin.notes.2session.index')
         @endif
        </div>
        @include('backend.pages.footer')
        </main>
        @stop