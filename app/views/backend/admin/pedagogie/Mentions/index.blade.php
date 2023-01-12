@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Liste des mentions @stop
@section('content') 
<!-- Workspace -->
<main class="workspace">
<section class="breadcrumb lg:flex items-start">       
<div class="mb-10">
@include('backend.break')
</div>
     <div class="flex flex-wrap gap-2 items-center ltr:ml-auto rtl:mr-auto mt-10 lg:mt-8">    
        <button class="btn btn_success" data-toggle="modal" data-target="#add"><i class="la la-plus"></i> Ajouter mention</button>
</div>
</section>
            <!-- Content -->
            <div class="card p-5">
                    <h3>Listes des mentions <small class="font-bold">Total:( {{(count($mentions))}} )</small></h3>
                    <table class="table-sorter table table_striped w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right ">#</th>
                                <th class="ltr:text-left rtl:text-right ">Intitulé</th>
                                <th class="ltr:text-left rtl:text-right ">Domaine</th>
                                <th class="ltr:text-left rtl:text-right ">Activer</th>
                                <th class="ltr:text-left rtl:text-right ">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($mentions as $mention)    
                            <tr class="font-bold">
                                <td>{{ $mention->id }}</td>
                                <td>{{ $mention->name }}</td>
                                <td><span class="badge badge_info">{{ $mention->domaine->name }}</span></td>
                                <td>
                                @if($mention->status == 1)<div class="badge badge_outlined badge_success ">Oui</div> @else <div class="badge badge_outlined badge_danger">Non</div> @endif
                                </td>
                                <td>
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{ URL::current() . '?id=' . $mention->id }}" class="btn btn-icon btn_outlined btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteP', $mention->id) }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
                                        <span class="la la-trash-alt"></span>
                                    </a>
                                    @endif @endif
                                </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
@include('backend.pages.footer')      
@section('js')
<script type="text/javascript">
 $('#parcours').select2();
</script>
@endsection  
    </main>
<!-- MODAL -->
    <div id="add" class="modal" data-animations="fadeInDown, fadeOutUp" data-static-backdrop>
       <div class="modal-dialog modal-dialog_centered max-w-2xl">
            <div class="modal-content w-full">
                <div class="modal-header">
                    <h2 class="modal-title">Ajouter Mentions</h2>
                    <button type="button" onclick="refresh();" class="close la la-times" data-dismiss="modal"></button>
                </div>
                    <div id="resultajax" class="center"></div>
                    {{ Form::open(['route'=>'storeM', 'class'=>'modal-body', 'id'=>'myForm', 'data-toggle'=>'validator']) }} 
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Intitulé</label>
                            <input id="name" name="name" type="text" class="form-control">
                        </div>                        
                        <div class="mb-5 domaine">
                            <label class="label block mb-2" for="domaine">Domaines</label>
                            <div class="custom-select">
                                <select class="form-control" name="domaine_id" id="domaine_id">
                                @foreach($domaines as $domaine)
                                    <option value="{{ $domaine->id }}">{{ $domaine->name }}</option>
                                @endforeach
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div> 
                     <div class="mb-5 parcours">
                            <label class="label block mb-2" for="parcours">Parcours</label>
                            <div class="custom-select parcours">  
                                <select class="form-control" name="parcour_id[]" id="parcours" multiple="multiple">
                                  <option disabled>--choisir Parcours--</option>
                                   @foreach($parcours as $parcour)
                                     <option value="{{ $parcour->id }}">{{ $parcour->name }}</option>
                                   @endforeach
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                    </div>
                <div class="modal-footer mt-5">
                    <div class="flex ltr:ml-auto rtl:mr-auto">
                        <button type="button" onclick="refresh();" class="btn btn_primary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn_success ltr:ml-2 rtl:mr-2">Ajouter</button>
                    </div>
                </div>
                {{ Form::close() }}
                @include('backend.admin.pedagogie.Mentions.ajaxAdd')      
            </div>
        </div>
    </div>     
@stop