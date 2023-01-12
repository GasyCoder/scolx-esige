@extends('backend.main')
@include('backend.timeAgo')
<?php $path = Session::get('language'); ?>
@section('title') Liste des certificats de Scolarité @stop
@section('content')
<!-- Workspace -->
    <main class="workspace workspace_with-sidebar">
    <section class="breadcrumb lg:flex items-start">
		<div>
		@include('backend.break')
		</div>
	</section>	
		        <!-- Actions -->
		        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
		            <a href="/admin/certificat-scolarite/etudiants/{{$class->id.'/'.$parcour->id}}" class="btn btn_primary">
		                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
		                Retour
		            </a>
		            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto"> 
		            <span class="btn btn_outlined btn_info">
		                    <span class="la la-certificate text-xl leading-none ltr:mr-0 rtl:ml-0"></span>
		                    Totale : {{count($certificates)}}
		            </span>
		            <a href="{{URL::route('motifCertifi', [$student->id, $student->class_id, $student->parcour_id])}}" class="btn btn_success">
		                    <span class="la la-plus text-xl leading-none ltr:mr-0 rtl:ml-0"></span>
		                    Nouveau certificat
		            </a>
		            </div>
		        </div>     
      			@include('backend.pages.alerts')
                <div class="card p-5">
                    <table class="table-sorter table table_bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">#</th>
                                <th class="ltr:text-left rtl:text-right">Réf</th>
                                <th class="ltr:text-left rtl:text-right">Motif de demande</th>
                                <th class="ltr:text-left rtl:text-right">Date</th>
                                <th class="text-center" style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($certificates as $certificate)
                            <tr>
                                <td>1</td>
                                <td>{{$certificate->ref}}</td>
                                <td>{{$certificate->motif}}</td>
                                <td>{{ \Carbon\Carbon::parse($certificate->created_at)->format('d M Y')}} ({{ timeAgo($certificate->created_at) }})</td>
                                <td class="text-center">
                                <a href="{{URL::route('printCertifi', [$certificate->id, $certificate->class_id,  $certificate->parcour_id, $certificate->ref])}}" target="_blank" class="btn btn-icon btn_secondary ltr:ml-2 rtl:mr-2">
                                  <span class="la la-print"></span>
                                </a>
                                <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteCertificat', $certificate->id) }}" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                        <span class="la la-trash-alt"></span>
                                </a>  
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
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
            <a href="#" class="flex items-center text-normal font-bold">
            	<span class="la la-user text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
            	{{$student->fname.' '.$student->lname}}
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Classe
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->name }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcour
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->abr }}</span>
            </a>
        </div>
    </aside>
@stop