@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Certificat de Scolarité @stop
@section('content')
<!-- Workspace -->
<main class="workspace workspace_with-sidebar">     
<div class="container flex items-center justify-center py-10">
        <div class="w-full md:w-1/2 xl:w-1/3">
            <div class="card p-5">
                <h3>NOUVEAU CERTIFICAT DE SCOLARITE</h3>
                <div class="mt-5">
                     {{ Form::open(['route'=>['submitCertifi', $student->id, $student->class_id, $student->parcour_id], 'class'=>'flex-shrink flex-wrap', 'id'=>'', 'data-toggle'=>''])  }}    
                    	<div class="mb-5">
                            <label class="label block mb-2" for="title">Etudiant</label>
                            <input type="text" class="form-control" value="{{$student->fname.' '.$student->lname}}" disabled>
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Motif de demande</label>
                            <textarea name="motif" class="form-control" rows="4" placeholder="Saisir le motif"></textarea>
                            <div class="help-block with-errors"></div>
                                @if($errors->first('motif'))
                                <span class="text-red-700">{{ $errors->first('motif') }}</span>
                                @endif
                        </div> 
                        <div class="mt-10">
                            <button type="submit" class="btn btn_primary"><i class="la la-check-square"></i> Confirmer</button>
                            @if($certifi > 0)
                            <a href="{{URL::route('readCertif', [$student->id, $student->class_id, $student->parcour_id])}}" class="btn btn_success ltr:ml-3 rtl:mr-3"><i class="la la-list"></i> Voir liste</a>
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
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcours->abr }}</span>
            </a>
         @if($certifi > 0)   
         <div class="alert alert_warning mt-5" style="color:#000">
              <strong class="uppercase"><bdi>Info!</bdi></strong>
              Cet étudiant a été demandé (<b>{{$certifi}}</b>) certificat(s) de scolarité!
        </div>
        @endif   
        </div>
        <hr>
    </aside>
@stop