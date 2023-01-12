@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Groupes @stop
@section('content') 
<!-- Workspace -->
<main class="workspace">
<section class="breadcrumb">        
@include('backend.break')
</section>
        <div class="grid lg:grid-cols-3 gap-5">
            <!-- Content -->
            <div class="lg:col-span-2">
            <div class="card p-5">
                    <h3>Listes des groupes <small class="font-bold">Total:( {{(count($groupes))}} )</small></h3>
                    <table class="table table_striped w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right ">#</th>
                                <th class="ltr:text-left rtl:text-right ">Nom du groupe</th>
                                <th class="ltr:text-left rtl:text-right ">Parcours</th>
                                <th class="ltr:text-left rtl:text-right ">Niveaux</th>
                                <th class="ltr:text-left rtl:text-right ">Activer</th>
                                <th class="ltr:text-left rtl:text-right ">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupes as $groupe)
                            <tr>
                                <td>{{ $groupe->id }}</td>
                                <td>{{ $groupe->name }}</td>
                                <td>@if($groupe->parcour_id == 0)
                                <div class="badge badge_outlined badge_danger">Aucun parcour</div>
                                @else {{ $groupe->parcour->name }}
                                @endif
                                </td>
                                <td>@if($groupe->class_id == 0) <div class="badge badge_outlined badge_danger">Aucun niveau</div> @else {{ $groupe->niveau->short }} @endif</td>
                                <td>
                                @if($groupe->status == 1)<div class="badge badge_outlined badge_success uppercase">Oui</div> @else <div class="badge badge_outlined badge_danger uppercase">Non</div> @endif
                                </td>
                                <td>
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{ URL::current() . '?id=' . $groupe->id }}" class="btn btn-icon btn_outlined btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteP', $groupe->id) }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
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
            </div>
<?php 
if (isset($_GET['id'])) { 
  
$id = htmlspecialchars($_GET['id']);

$getGroupe = Groupe::find($id);

if ($getGroupe !== null) {  ?>

            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">
                    <h3>Modifier Groupe</h3>
                  <div id="resultajax2" class="center"></div>    
                   {{ Form::open(['route'=>['groupeUpdate',$getGroupe->id], 'class'=>'', 'id'=>'myForm2', 'data-toggle'=>'validator'])  }}    
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Titre</label>
                            <input id="name" name="name" value="{{$getGroupe->name}}" type="text" class="form-control">
                        </div>
                        <input type="text" name="" value="{{$getGroupe->id}}">
                        <div class="mb-5">
                            <label class="label block mb-2" for="category">Niveaux</label>
                            <div class="custom-select">
                                <?php $check_class = TheClass::find($getGroupe->class_id);
                                    $classes_array = TheClass::lists('short', 'id');  ?>
                                    @if($check_class !== null)
                                    {{ Form::select('class_id', array($check_class->id => $check_class->short) + $classes_array + [], '', ['class'=>'form-control', 'id'=>'class']) }}
                                    @else
                                    {{ Form::select('class_id', array('' => 'Tous les niveaux') + $classes_array, '', ['class'=>'form-control', 'id'=>'class']) }}
                                    @endif
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div>
                         <div class="mb-5">
                            <label class="label block mb-2" for="parcours">Parcours</label>
                            <div class="custom-select parcours">
                               <select name="parcour_id" id="parcours" class="form-control">
                                    @if(!empty($getGroupe->parcour_id))
                                    <option value="{{$getGroupe->parcour_id}}" selected="selected">{{$getGroupe->parcour->name}}</option>
                                    @else
                                    <option selected disabled>Choisir</option>
                                    @endif
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div>
@include('backend.admin.pedagogie.Groupes.dep')
                        <div class="flex items-center">
                            <div class="w-1/2">
                                <label class="label block">Status</label>
                            </div>
                            <div class="w-3/4 ml-2">
                                <label class="label switch">
                                    @if($getGroupe->status == 1)
                                    <input type="checkbox" name="status" checked value="1">
                                    <span></span>
                                    <span>Activer</span>
                                    @else
                                    <input type="checkbox" name="status" value="0">
                                    <span></span>
                                    <span>Désactiver</span>
                                    @endif
                                </label>
                            </div>
                        </div>
                        <div class="mt-10">
                            <button class="btn btn_primary uppercase">Metre à jour</button>
                        </div>
                      {{ Form::close() }}
                @include('backend.admin.pedagogie.Groupes.jsUp')
                </div>
            </div>

<?php } } else { ?>

            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">
                    <h3>Ajouter Groupes</h3>
                    <div id="resultajax" class="center"></div>
                    {{ Form::open(['route'=>'groupeStore', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator']) }} 
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Intitulé</label>
                            <input id="name" name="name" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="class_id">Niveaux</label>
                            <div class="custom-select">
                                <select class="form-control" name="class_id" id="class">
                                    <option selected disabled>Choisir</option>
                                    @foreach($classes as $class)
                                       <option value="{{ $class->id }}">{{ $class->short }}</option>
                                    @endforeach
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="parcours">Parcour</label>
                            <div class="custom-select parcours">
                                <select class="form-control" name="parcour_id" id="parcours">
                                    <option>Choisir</option>
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div>

   @include('backend.admin.pedagogie.Groupes.dep')

                        <div class="flex items-center">
                            <div class="w-1/2">
                                <label class="label block">Activer</label>
                            </div>
                            <div class="w-3/4 ml-2">
                                <label class="label switch">
                                    <input type="checkbox" name="status" checked value="1">
                                    <span></span>
                                    <span>Activé</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-10">
                            <button type="submit" class="btn btn_primary uppercase">Ajouter</button>
                        </div>
                {{ Form::close() }}
                @include('backend.admin.pedagogie.Groupes.jsAdd')
                </div>
            </div>
            
<?php }  ?>   

</div>
@include('backend.pages.footer')        
</main>
@stop