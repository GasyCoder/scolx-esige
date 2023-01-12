@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') {{$title.' '. $domaine->name}} @stop
@section('content')
    <main class="workspace">
<section class="breadcrumb lg:flex items-start">   
<div>   
</div>
</section>
    <div class="container flex items-center justify-center mb-2 py-1">
        <div class="card p-5 flex flex-col gap-y-2 w-full md:w-1/2 xl:w-1/4">
            <a href="/admin/domaines"><span class="la la-arrow-left"></span> Retour</a>
            <div class="mx-2 md:mx-3">
                <h2 class=""> <span class="la la-edit"></span>{{$title}}</h2>
            </div>
            <div id="resultajax2" class="center"></div>
           {{ Form::open(['route'=>['updateD', $domaine->id], 'class'=>'', 'id'=>'myForm2', 'data-toggle'=>'validator'])  }}    
                        <div class="mb-5 px-4 w-full">
                            <label class="label block mb-2" for="title">Intitulé</label>
                            <input id="name" name="name" value="{{$domaine->name}}" type="text" class="form-control">
                        </div>
                        <div class="mb-5 px-4 parcours w-full">
                            <label class="label block mb-2" for="parcours">Parcours</label>
                             <div class="custom-select">
                              <select class="form-control" name="parcour_id[]" id="parcours" multiple="multiple">
							   @if(!empty($parcour->id)) 
                                <option value="{{$parcour->id}}" selected style="color:red">
                                	{{$parcour->name}}
                                </option>
                                @else
                                <option disabled selected>--choisir--</option>
                                @endif  
                                   @foreach($parcours as $par)
                                     <option value="{{ $par->id }}">{{ $par->name }}</option>
                                   @endforeach
                                </select>
                            <div class="custom-select-icon la la-caret-down"></div>
                        </div>
                        </div>
                        <div class="flex items-center px-4 w-full">
                            <div class="w-1/2">
                                <label class="label block">Status</label>
                            </div>
                            <div class="w-3/4 ml-2">
                                <label class="label switch">
                                    @if($domaine->status == 1)
                                    <input type="checkbox" name="status" checked value="1">
                                    <span></span>
                                    <span>Activer</span>
                                    @else
                                    <input type="checkbox" name="status" value="0">
                                    <span></span>
                                    <span>Activer</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="mt-10 px-4 w-full">
                            <button class="btn btn_success">Metre à jour</button>
                        </div>
           {{ Form::close() }}
            @include('backend.admin.pedagogie.Domaines.ajaxUp')
        </div>
    </div>
@include('backend.pages.footer')
@section('js')
<script type="text/javascript">
 $('#parcours').select2();
</script>
@endsection 
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
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcours
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->name }}</span>
            </a>
        </div>
    </aside>
@stop