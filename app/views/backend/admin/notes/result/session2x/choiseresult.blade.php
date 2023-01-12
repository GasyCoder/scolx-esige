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
            <h3>Résultats des examens</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/resultats_examen/session_2/officiel/{{$class->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
            <button class="btn btn_outlined btn_success">
                    Année Universitaire: {{$year->yearsUniv}} 
            </button>    
            </div>
        </div> 
      
        <div class="p-5 mt-3">
            <div class="overflow-x-auto">
            <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-5 flex">
            
            {{ Form::open(['route'=>['submit2session', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }}
            
               <table class="table table_bordered w-full" style="display:none">
                    <tbody> 
                    @foreach($sessionsdeux as $sessions)
                        <?php 
                            $mynotes        = Note::where('class_id',           $sessions->class_id)
                                                        ->where('parcour_id',   $sessions->parcour_id)
                                                        ->where('id_student',   $sessions->id_student)
                                                        ->groupBy('codeEc')
                                                        ->get(); 

                             $TotalCoefs     = EC::where('class_id', $sessions->class_id)
                                                        ->where('parcour_id', $sessions->parcour_id)
                                                        ->groupBy('class_id')
                                                        ->sum('coef');

                        ?> 
                        <tr>
                            <td>
                                <input type="text" name="id_student[]" value="{{$sessions->id_student}}">
                            </td>
                            <td>
                                <input type="hidden" name="yearsUniv[]" value="{{$sessions->yearsUniv}}">
                            </td>
                            <td>
                                <input type="hidden" name="class_id[]" value="{{$sessions->niveau->id}}"> 
                                <input type="hidden" name="parcour_id[]" value="{{$sessions->parcour->id}}">
                            </td>
                            <td>
                                <input type="hidden" name="grade[]" value="{{$sessions->grade}}">
                            </td>
                           <td>
                            <table style="display:block">
                                <?php
                                    $totalPondere   = 0;    
                                ?>
                                @foreach($mynotes as $mynote)
                                <?php
                                $coefi             = EC::where('id', $mynote->element_id)->first();
                                $NotePondere       = $mynote->note*$coefi->coef; 
                                $totalPondere     += $NotePondere;
                                ?>
                                   <tr>
                                       <td style="display:none">{{number_format($NotePondere, 2, ',', '')}}</td>
                                   </tr>
                                @endforeach   
                            </table>
                           </td>
                           <td>    
                            <table class="table_bordered" width="100%">
                              <tr style="line-height:12px;">
                                <td>
                                  <input type="hidden" name="somme[]" value="{{number_format($totalPondere, 2, ',', '')}}">
                                </td>
                              </tr>
                            </table>
                           </td>
                           <td>    
                            <table class="table_bordered" width="100%">
                              <tr style="line-height:12px;">
                                <?php $moyenne =  $totalPondere/$TotalCoefs; ?>
                                <td><input type="hidden" name="moyenne[]" value="{{number_format($moyenne, 2, ',', '')}}"></td>
                              </tr>
                            </table>
                           </td>
                           <td>    
                            <table class="table_bordered" width="100%">
                              <tr style="line-height:12px;">
                                <td>
                                @if($moyenne >= 10)  
                                  <input type="hidden" name="admis[]" value="1">
                                @elseif($moyenne >= 5.50 && $moyenne <= 9.99)
                                  <input type="hidden" name="admis[]" value="0">
                                @else
                                  <input type="hidden" name="admis[]" value="9">
                                @endif
                                </td>
                              </tr>
                            </table>
                           </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($ifhasresults > 0)
                   <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                     <a href="{{URL::route('affichageSession2', [$class->id, $parcour->id])}}">   
                        <div class="card card_hoverable card_list" style="color:#047857">
                            <div class="image image_icon">
                                <span class="la la-file-alt la-4x"></span>
                            </div>
                            <div class="body">
                                <h5>Résultats pour affichage</h5>
                                <p>Version numérique</p>
                            </div>
                        </div>
                      </a>
                   </div>
                @else
                <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                     <button>    
                        <div class="card card_hoverable card_list" style="color:#047857">
                            <div class="image image_icon">
                                <span class="la la-file-alt la-4x"></span>
                            </div>
                            <div class="body">
                                <h5>Résultats pour affichage</h5>
                                <p>Version numérique</p>
                            </div>
                        </div>
                    </button>
                   </div>
                @endif
            {{ Form::close() }}
       

            {{ Form::open(['route'=>'bilanNonadmis', 'class'=>'flex-shrink flex-wrap'])}}
               <table class="table table_bordered w-full" style="display:none">
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" name="id_student[]" value="">
                            </td>
                            <td>
                                <input type="hidden" name="yearsUniv[]" value="">
                            </td>
                            <td class="font-bold">
                                <input type="hidden" name="class_id[]" value=""> 
                                <input type="hidden" name="parcour_id[]" value="">
                            </td>
                            <td>
                                <input type="hidden" name="grade[]" value="">
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="moyenne[]" value="">
                           </td>
                        </tr>
                    </tbody>
                </table>

                <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5" style="display:none">
                <a href="{{URL::route('returnNonAdmis')}}">      
                    <div class="card card_hoverable card_list" style="color:#0EA5E9">
                        <div class="image image_icon">
                            <span class="la la-envelope la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Résultats envoyer par email</h5>
                            <p>Version virtuel</p>
                        </div>
                    </div>
                </a>
               </div>
           {{ Form::close() }}
            </div>  
            </div>
        </div> 

@include('backend.pages.footer')
</main>
@stop