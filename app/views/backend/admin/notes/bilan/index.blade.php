@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">
@if($control->openNote > 0)        
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Bilan des examens</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/resultats_examen/class/etudiants" class="btn btn_outlined btn_primary">
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
            
             {{ Form::open(['route'=>'bilanadmis', 'class'=>'flex-shrink flex-wrap'])}}

               <table class="table table_bordered w-full" style="display:none">
                    <tbody>
                    @foreach($noteS as $admis)
                    <?php 
                        $forAdmis  = Note::where('id_student', $admis->id_student)
                                           ->where('class_id', $admis->class_id)
                                           ->groupBy('id_student')
                                           ->avg('note'); 
                    ?>
                    @if($forAdmis >= 10)
                        <tr>
                            <td>
                                <input type="hidden" name="id_student[]" value="{{$admis->stud->id}}">
                            </td>
                            <td>
                                <input type="hidden" name="yearsUniv[]" value="{{$admis->yearsUniv}}">
                            </td>
                            <td class="font-bold">
                                <input type="hidden" name="class_id[]" value="{{$admis->niveau->id}}"> 
                                <input type="hidden" name="parcour_id[]" value="{{$admis->parcour->id}}">
                            </td>
                            <td>
                                <input type="hidden" name="grade[]" value="{{$admis->grade}}">
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="moyenne[]" value="{{number_format($forAdmis, 2, '.', '')}}">
                           </td>
                        </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
                @if($ifhasAdmis > 0)
                <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                <a href="{{URL::route('returnAdmis')}}">      
                    <div class="card card_hoverable card_list" style="color:#047857">
                        <div class="image image_icon">
                            <span class="la la-hand-point-right la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Bilan pour les admis</h5>
                            <p><span class="la la-users text-xl leading-none"></span>Tous les classes</p>
                        </div>
                    </div>
                </a>
               </div>
               @else
               <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                 <button>    
                    <div class="card card_hoverable card_list" style="color:#047857">
                        <div class="image image_icon">
                            <span class="la la-hand-point-right la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Bilan pour les admis</h5>
                            <p><span class="la la-users text-xl leading-none"></span>Tous les classes</p>
                        </div>
                    </div>
                </button>
               </div>
               @endif
            {{ Form::close() }}
            


            {{ Form::open(['route'=>'bilanNonadmis', 'class'=>'flex-shrink flex-wrap'])}}
               <table class="table table_bordered w-full" style="display:none">
                    <tbody>
                    @foreach($noteS as $admis)
                    <?php 
                        $forAdmis  = Note::where('id_student', $admis->id_student)
                                           ->where('class_id', $admis->class_id)
                                           ->groupBy('id_student')
                                           ->avg('note'); 
                    ?>
                    @if($forAdmis <= 9.99)
                        <tr>
                            <td>
                                <input type="hidden" name="id_student[]" value="{{$admis->stud->id}}">
                            </td>
                            <td>
                                <input type="hidden" name="yearsUniv[]" value="{{$admis->yearsUniv}}">
                            </td>
                            <td>
                                <input type="hidden" name="class_id[]" value="{{$admis->niveau->id}}"> 
                                <input type="hidden" name="parcour_id[]" value="{{$admis->parcour->id}}">
                            </td>
                            <td>
                                <input type="hidden" name="grade[]" value="{{$admis->grade}}">
                            </td>
                            <td class="text-center">
                                <input type="hidden" name="moyenne[]" value="{{number_format($forAdmis, 2, '.', '')}}">
                           </td>
                        </tr>
                    @endif
                    @endforeach
                    </tbody>
                </table>
                @if($ifhasNonAdmis > 0)
                <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                <a href="{{URL::route('returnNonAdmis')}}">      
                    <div class="card card_hoverable card_list" style="color:#B91C1C">
                        <div class="image image_icon">
                            <span class="la la-hand-point-left la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Bilan pour les Non admis</h5>
                            <p><span class="la la-users text-xl leading-none"></span>Tous les classes</p>
                        </div>
                    </div>
                </a>
               </div>
               @else
               <div class="grid sm:grid-cols-1 xl:grid-cols-1 gap-5">
                 <button>    
                    <div class="card card_hoverable card_list" style="color:#B91C1C">
                        <div class="image image_icon">
                            <span class="la la-hand-point-left la-4x"></span>
                        </div>
                        <div class="body">
                            <h5>Bilan pour les Non admis</h5>
                            <p><span class="la la-users text-xl leading-none"></span>Tous les classes</p>
                        </div>
                    </div>
                </button>
               </div>
               @endif
           {{ Form::close() }}
            </div>  
            </div>
        </div> 
@else
    <div class="container flex items-center justify-center mb-2 py-1">
        <div class="card p-5 flex flex-col gap-y-2 w-full md:w-1/2 xl:w-1/4">
            <div class="mx-2 md:mx-3">
                <h3 class="" style="color:#DC2626"> <span class="la la-exclamation-triangle"></span>Attention!</h3>
            </div>
            <hr class="border-dashed">
                <div class="modal-body text-xl">
                    Cette page ne peut pas être ouverte avant l'inclusion de toutes les notes des étudiants!
                </div>
                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                <div class="modal-footer">
                    <div class="flex ltr:ml-auto rtl:mr-auto">
                        <a onclick="return confirm('Vous êtes vraiment sur?')" href="{{ URL::route('alertOpen') }}" class="btn btn_primary ltr:ml-2 rtl:mr-2">Activer cette page</a>
                    </div>
                </div>
                @endif @endif   
        </div>
    </div>
@endif
@include('backend.pages.footer')
</main>
@stop