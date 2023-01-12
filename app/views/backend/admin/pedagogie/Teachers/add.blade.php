@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Ajouter enseignant @stop
@section('content')
<!-- Workspace -->
<main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb">
            <h1>Ajouter enseignant</h1>
            <ul>
                <li><a href="#">Enseignant</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Ajouter</li>
            </ul>
        </section>  
        <!-- Actions -->
        <div class="card p-3 flex flex-wrap gap-2 breadcrumb breadcrumb_alt">
            <a href="{{URL::route('indexTeacher')}}" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <a href="{{URL::route('indexTeacher')}}" class="btn btn_warning text-primary">
                    <span class="la la-th-list text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Liste des enseignants
                </a>
            </div>
        </div>     
@include('backend.admin.administration.Pay.return')
        <div class="grid lg:grid-cols-4 gap-5 mt-2">
            <!-- Content -->
            <div class="lg:col-span-2 xl:col-span-3">
                <div class="card p-5">
                    {{ Form::open(['route'=>'SaveTeacher', 'files'=>'true', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator'])  }}

                            <div class="tab-content mt-8">
                            <div class="flex flex-wrap flex-row -mx-4 collapse open">  
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="fname">Nom *</label>
                                {{ Form::text('fname', '', ['id'=>'fname', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('fname'))
                                <span class="text-red-700">{{ $errors->first('fname') }}</span>
                                @endif
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="lname">Prénom <small>(option)</small></label>
                                {{ Form::text('lname', '', ['id'=>'lname', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="grade">Grade *</label>
                                <div class="custom-select">
                                <select class="form-control" name="grade" id="grade">
                                    <option selected disabled>--choisir grade--</option>
                                    <option value="Assistant">Assistant(e)</option>
                                    <option value="Dr.">Docteur</option>
                                    <option value="Pr.">Professeur</option>
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                 <div class="help-block with-errors"></div>
                                @if($errors->first('grade'))
                                <span class="text-red-700">{{ $errors->first('grade') }}</span>
                                @endif     
                                </div>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="sexe">Genre *</label>
                                <div class="custom-select">
                                <select class="form-control" name="sexe" id="sexe">
                                    <option selected disabled>--choisir genre--</option>
                                    <option value="1">Homme</option>
                                    <option value="2">Femme</option>
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                 <div class="help-block with-errors"></div>
                                @if($errors->first('sexe'))
                                <span class="text-red-700">{{ $errors->first('sexe') }}</span>
                                @endif     
                                </div>
                            </div>
                           <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="nationality">Nationalité *</label>
                                <div class="custom-select">
                                <select class="form-control" name="nationality" id="nationality">
                                    <option selected disabled>--choisir nationalité--</option>
                                    <option value="0">Malagasy</option>
                                    <option value="1">Français</option>
                                    <option value="2">Comoriens</option>
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('nationality'))
                                <span class="text-red-700">{{ $errors->first('nationality') }}</span>
                                @endif    
                                </div>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="birth">Date de naissance *</label>
                                {{ Form::text('birth', '', ['placeholder'=>'jj/mm/aaaa', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('birth'))
                                <span class="text-red-700">{{ $errors->first('birth') }}</span>
                                @endif 
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="birthLocation">Lieu de naissance *</label>
                                {{ Form::text('birthLocation', '', ['id'=>'birthLocation', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('birthLocation'))
                                <span class="text-red-700">{{ $errors->first('birthLocation') }}</span>
                                @endif 
                            </div>

                            <div class="mb-5 flex-shrink px-4 xl:w-1/2">
                                <label class="label block mb-2" for="email">Email*</label>
                                {{ Form::email('email', '', ['id'=>'email', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="phone_1">Téléphone 1 *</label>
                                {{ Form::text('phone_1', '', ['id'=>'phone_1', 'class'=>'form-control']) }}
                               <div class="help-block with-errors"></div>
                                @if($errors->first('phone_1'))
                                <span class="text-red-700">{{ $errors->first('phone_1') }}</span>
                                @endif    
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="phone_2">Téléphone 2</label>
                                {{ Form::text('phone_2', '', ['id'=>'phone_2', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="facebook">Facebook</label>
                                {{ Form::text('facebook', '', ['id'=>'facebook', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="address">Adresse *</label>
                                {{ Form::text('address', ' ', ['id'=>'address', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('address'))
                                <span class="text-red-700">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5 dropzone">
                    <label class="input-group font-normal" for="customFile">
                        <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">Photo de profil
                        </div>
                        <input id="customFile" type="file" name="image" class="hidden">
                        <div class="input-group-item btn btn_primary">Parcourir</div>
                    </label>
                </div>
                <div class="flex flex-wrap gap-2 mt-0">
                    <button type="submit" class="btn btn_success"><span class="la la-plus-circle"></span> Ajouter enseignant</button>
                </div>
            </div>
 {{ Form::close() }}
</div>
 @include('backend.pages.footer')       
</main>   
@stop
