@extends('backend.main')
<?php 
$path = Session::get('language'); 
$control = Control::find(1);
$delibera = Delibera::where('class_id', $class->id)
                        ->where('parcour_id', $parcour->id) 
                        ->where('semestre', 1) 
                        ->where('session', 1)
                        ->first();
?>
@section('title') Activation Semestre 1 @stop
@section('content')
<!-- Workspace -->
<main class="workspace workspace_with-sidebar">     
<div class="container flex items-center justify-center py-10">
        <div class="w-full md:w-1/2 xl:w-1/3">
            <div class="card p-5">
                <h3>ACTIVATION SEMESTRE 1</h3>
                <div class="mt-5">
                   {{ Form::open(['route'=>['submitDeliber', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }} 
                    <div class="mb-5">
                            <label class="label block mb-2" for="title">Etudiants présents pour l'examen semestre 1</label>
                            <input type="number" class="form-control" value="{{count($students)}}" disabled>
                    </div>
                    @foreach($delibers as $deliber) 	
                     <?php      
                        $totalponder        = Credit::where('id_student',       $deliber->id_student)
                                                    ->where('class_id',         $class->id)
                                                    ->where('parcour_id',       $parcour->id)
                                                    ->where('yearsUniv',        $deliber->yearsUniv)
                                                    ->where('semestre', 1)
                                                    ->where('session', 1)
                                                    ->sum('Noteponder');                             
                    
                        $summeCoef          = Credit::where('id_student',       $deliber->id_student)
                                                    ->where('class_id',         $class->id)
                                                    ->where('parcour_id',       $parcour->id)
                                                    ->where('semestre', 1)
                                                    ->where('session', 1)
                                                    ->sum('coef'); 
                        $deliberation       = Deliberation::where('session', 1)->first();                         
                    ?>
                        <div class="mb-5" style="display:none;">
                            <input type="number" class="form-control" name="deliberation[]" value="{{$deliberation->moyenne}}">
                            <input type="text" class="form-control"   name="id_student[]" value="{{$deliber->stud->id}}">   
                            <input type="text" class="form-control" name="class_id[]" value="{{$class->id}}"> 
                            <input type="text" class="form-control" name="parcour_id[]" value="{{$parcour->id}}">
                            <input type="text" class="form-control" name="grade[]" value="{{$deliber->grade}}">
                            <input type="text" class="form-control" name="yearsUniv[]" value="{{$deliber->yearsUniv}}"> 
                            <input type="text" class="form-control" name="somme[]" value="{{number_format($totalponder, 2, '.', '')}}">
                            @if($totalponder > 0)
                            <?php  $moyenes_One  =  ($totalponder/30); ?>
                            <input type="text" class="form-control" name="moyenne[]" value="{{number_format($moyenes_One, 2, '.', '')}}">
                            @else
                            <input type="text" class="form-control" name="moyenne[]" value="0">
                            @endif

                        </div> 
                    @endforeach   
                    <div class="mt-10">
                            @if(empty($delibera->deliberation))
                            <a href="/admin/resultats_examen/semestre_1/vérification/{{$class->id}}/{{$parcour->id}}" class="btn btn_primary"><i class="la la-undo"></i> Retour</a>
                            <button onclick="return confirm('êtes-vous sur pour activer ces résultats?')" type="submit" class="btn btn_success ltr:ml-3 rtl:mr-3"><i class="la la-check-square"></i> Confirmer  
                            </button>
                            @else
                            <a onclick="return confirm('êtes-vous sur pour restaurer?')" href="{{URL::route('restoreDeliber_2', [$class->id, $parcour->id])}}" class="btn btn_danger ltr:ml-3 rtl:mr-3"><i class="la la-trash"></i> Restaurer</a>
                            @endif
                    </div> 
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        </div>
</div>
@include('backend.pages.footer')
</main>
    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tags -->
        <h2 class="p-5">Objets sélectionnés</h2>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-user-graduate text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Classe
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->name }}</span>
            </a>
             <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcour
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->abr }}</span>
            </a>
        </div>
        <hr>
    </aside>
@stop