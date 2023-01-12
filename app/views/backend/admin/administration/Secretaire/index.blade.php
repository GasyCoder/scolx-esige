@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Les sécretaires @stop
@section('content') 
<main class="workspace">
<section class="breadcrumb">        
@include('backend.break')
</section>

        <div class="grid lg:grid-cols-3 gap-5">
@include('backend.pages.alerts')        	
            <!-- Content -->
            <div class="lg:col-span-2">
            <div class="card p-5">
                    <h3>Listes des sécretaires</h3>
                    <table class="table table_striped w-full mt-3">
                        <thead>
                            <tr>
                                <th class="ltr:text-left rtl:text-right">#</th>
                                <th class="ltr:text-left rtl:text-right">Nom</th>
                                <th class="ltr:text-left rtl:text-right">Prénom</th>
                                <th class="ltr:text-left rtl:text-right">Email</th>
                                <th class="ltr:text-left rtl:text-right">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($secretaires as $sec)   
                            <tr>
                                <td>{{ $sec->id }}</td>
                                <td>{{ $sec->fname }}</td>
                                <td>{{ $sec->lname }}</td>
                                <td>{{ $sec->email }}</td>
                                <td>
                                @if($sec->confirmed == 1)<div class="badge badge_outlined badge_success">Oui</div> @else <div class="badge badge_outlined badge_danger">Non</div> @endif
                                </td>
                                <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                    <a href="{{ URL::current() . '?id=' . $sec->id }}" class="btn btn-icon btn_outlined btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    <a onclick="return confirm('Etes vous sur de supprimer votre sécretaire?')" href="{{ URL::route('deleteSec', $sec->id) }}" class="btn btn-icon btn_outlined btn_danger ltr:ml-2 rtl:mr-2">
                                        <span class="la la-trash-alt"></span>
                                    </a>
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
$getSec = User::find($id);
if ($getSec !== null) {  ?>

            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">
                <a href="{{URL::route('secretaires')}}"><span class="la la-arrow-left"></span> Retour</a>	
                    <h3>Modifier Secretaire</h3>
                  <div id="resultajax2" class="center"></div>    
                   {{ Form::open(['route'=>['updateSec',$getSec->id], 'class'=>'', 'id'=>'myForm2', 'data-toggle'=>'validator'])  }}    
                        <div class="mb-5">
                            <label class="label block mb-2" for="title">Nom</label>
                            <input id="fname" name="fname" value="{{$getSec->fname}}" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Prénom</label>
                           <input id="lname" name="lname" value="{{$getSec->lname}}" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Email *</label>
                           <input id="email" name="email" value="{{$getSec->email}}" type="email" class="form-control">
                        </div>
                        <div class="flex items-center">
                            <div class="w-1/2">
                                <label class="label block">Status</label>
                            </div>
                            <div class="w-3/4 ml-2">
                                <label class="label switch">
                                    @if($getSec->confirmed == 1)
                                    <input type="checkbox" name="confirmed" checked value="1">
                                    <span></span>
                                    <span>Activé</span>
                                    @else
                                    <input type="checkbox" name="confirmed" value="0">
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
                @include('backend.admin.administration.Secretaire.jsUp')
                </div>

                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">	
                    <h3>Changer Mot de passe</h3> 
                   {{ Form::open(['route'=>['updateCode',$getSec->id], 'class'=>'', 'id'=>'myForm2', 'data-toggle'=>'validator'])  }}    
                        <div class="mb-5">
		                    <label class="label block mb-2" for="password">Mot de passe actuel</label>
		                    <label class="form-control-addon-within">
		                        <input id="password" type="password" name="old_password" class="form-control border-none">
		                        <span class="flex items-center ltr:pr-4 rtl:pl-4">
		                            <button type="button"
		                                class="btn btn-link text-gray-300 dark:text-gray-700 la la-eye text-xl leading-none"
		                                data-toggle="password-visibility"></button>
		                        </span>
		                    </label>
		                </div>
		                <div class="mb-5">
		                    <label class="label block mb-2" for="password">Nouveau mot de passe</label>
		                    <label class="form-control-addon-within">
		                        <input id="password" type="password" name="password" class="form-control border-none">
		                        <span class="flex items-center ltr:pr-4 rtl:pl-4">
		                            <button type="button"
		                                class="btn btn-link text-gray-300 dark:text-gray-700 la la-eye text-xl leading-none"
		                                data-toggle="password-visibility"></button>
		                        </span>
		                    </label>
		                </div>
		                <div class="mb-5">
		                    <label class="label block mb-2" for="password">Confirmer mot de passe</label>
		                    <label class="form-control-addon-within">
		                        <input id="password" type="password" name="password_confirm" class="form-control border-none">
		                        <span class="flex items-center ltr:pr-4 rtl:pl-4">
		                            <button type="button"
		                                class="btn btn-link text-gray-300 dark:text-gray-700 la la-eye text-xl leading-none"
		                                data-toggle="password-visibility"></button>
		                        </span>
		                    </label>
		                </div>
                        <div class="mt-10">
                            <button class="btn btn_primary uppercase">Metre à jour</button>
                        </div>
                      {{ Form::close() }}
                </div>
            </div>


<?php } } else { ?>

            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5">
                    <h3>Ajouter Niveau</h3>
                    <div id="resultajax" class="center"></div>
                    {{ Form::open(['route'=>'storeSec', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator']) }} 
                       <div class="mb-5">
                            <label class="label block mb-2" for="title">Nom *</label>
                            <input id="fname" name="fname" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Prénom (option)</label>
                           <input id="lname" name="lname" type="text" class="form-control">
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Email *</label>
                           <input id="email" name="email" type="email" class="form-control">
                        </div>
		                <div class="mb-5">
		                    <label class="label block mb-2" for="password">Mot de passe</label>
		                    <label class="form-control-addon-within">
		                        <input id="password" type="password" name="password" class="form-control border-none">
		                        <span class="flex items-center ltr:pr-4 rtl:pl-4">
		                            <button type="button"
		                                class="btn btn-link text-gray-300 dark:text-gray-700 la la-eye text-xl leading-none"
		                                data-toggle="password-visibility"></button>
		                        </span>
		                    </label>
		                </div>
                        <div class="mt-10">
                            <button type="submit" class="btn btn_primary uppercase">Ajouter</button>
                        </div>
                {{ Form::close() }}
                @include('backend.admin.administration.Secretaire.jsAdd')
                </div>
            </div>
<?php }  ?>   
        </div>
@include('backend.pages.footer')        
    </main>
@stop