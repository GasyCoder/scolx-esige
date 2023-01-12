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
@section('title') Activation Résultats - 2e Session @stop
@section('content')
<!-- Workspace -->
<main class="workspace workspace_with-sidebar">     
<div class="container flex items-center justify-center py-10">
        <div class="w-full md:w-1/2 xl:w-1/3">
            <div class="card p-5">
                <a href="/admin/resultats_examen/session_2/vérification/{{$class->id}}/{{$parcour->id}}" class="badge badge_outlined badge_primary mb-3"><i class="la la-undo"></i> Retour</a><hr>
                <h3>ACTIVATION SESSION 2</h3>
                <div class="mt-5">
                   <div class="mb-2">
                            <label class="label block mb-2" for="title">Etudiants présents pour l'examen session 2</label>
                            <input type="number" class="form-control" value="{{count($students)}}" disabled>
                    </div>
                   {{ Form::open(['route'=>['valid2session', $class->id, $parcour->id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }} 
                    @foreach($delibers as $deliber)
                    <?php 
                    $var_1      = Delibera::where('somme', '>=', 600)
                                            ->where('class_id',   $class->id)
                                            ->where('parcour_id', $parcour->id)
                                            ->where('session', 2)
                                            ->where('semestre', 3)
                                            ->where('status', 1)
                                            ->count();
                     $var_2      = Delibera::where('somme', '>=', 570)
                                            ->where('class_id',   $class->id)
                                            ->where('parcour_id', $parcour->id)
                                            ->where('session', 2)
                                            ->where('semestre', 3)
                                            ->where('status', 1)
                                            ->count();

                     $var_3      = Delibera::where('somme', '>=', 540)
                                            ->where('class_id',   $class->id)
                                            ->where('parcour_id', $parcour->id)
                                            ->where('session', 2)
                                            ->where('semestre', 3)
                                            ->where('status', 1)
                                            ->count();

                     $test1       = $deliber->moyenne;
                     $test2       = $deliber->deliberation;
                     //$comp        = $test2 >= $test1; 

                    ?> 	
                        <div class="mb-5" style="display:none;">
                            <input type="text" class="form-control"   name="id_student[]" value="{{$deliber->stud->id}} ">   
                            <input type="hidden" class="form-control" name="class_id[]"   value="{{$class->id}}"> 
                            <input type="hidden" class="form-control" name="parcour_id[]" value="{{$parcour->id}}">
                            <input type="hidden" class="form-control" name="grade[]"     value="{{$deliber->stud->grade}}">
                            <input type="hidden" class="form-control" name="yearsUniv[]" value="{{$deliber->yearsUniv}}"> 
                            <input type="text" class="form-control"   name="somme[]"     value="{{$deliber->somme}}">
                            <input type="text" class="form-control"   name="moyenne[]" value="{{$test1}}">
                            <input type="hidden" class="form-control" name="moisPayed[]" value="{{$deliber->stud->mois_reste}}">
                            @if($test1 >= $test2)
                                <input type="text" class="form-control" name="admis[]" value="1">
                            @else
                                <input type="text" class="form-control" name="admis[]" value="0">  
                            @endif
                    </div>
                    @endforeach   
                    <hr>
                        <label class="label block mb-2" for="title">Si délibération >= 10.0</label>
                        <input type="number" class="form-control" value="{{$var_1}}" disabled>
                        <label class="label block mb-2" for="title">Si délibération >= 9.50</label>
                        <input type="number" class="form-control" value="{{$var_2}}" disabled> 
                        <label class="label block mb-2" for="title">Si délibération >= 9.0</label>
                        <input type="number" class="form-control" value="{{$var_3}}" disabled>       

                    <div class="mt-10">
                            
                             <a onclick="return confirm('êtes-vous sur pour restaurer?')" href="{{URL::route('supprimer2', [$class->id, $parcour->id])}}" class="btn btn_danger ltr:ml-3 rtl:mr-3"><i class="la la-trash"></i> Restaurer</a>

                            <button onclick="return confirm('êtes-vous sur pour activer ces résultats?')" type="submit" class="btn btn_success ltr:ml-3 rtl:mr-3"><i class="la la-check-square"></i> Confirmer  
                            </button>
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