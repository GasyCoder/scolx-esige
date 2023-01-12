@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') {{ Lang::get($path.'.new_student') }} @stop
@section('content')
<!-- Workspace -->
<main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb">
            <h1>Ajouter étudiant</h1>
            <ul>
                <li><a href="#">Etudiants</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Ajouter</li>
            </ul>
        </section>  
        <!-- Actions -->
        <div class="card p-3 flex flex-wrap gap-2 breadcrumb breadcrumb_alt">
            <a href="/admin/etudiants/inscription/{{$class->id}}" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @if($etudiants > 0)
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <button class="btn btn_info">
                <span class="la la-users"></span>
                Total étudiant: {{$allStud}}
                </button>
                <button class="btn btn_secondary">
                <span class="la la-users"></span>
                Inscrit (classe et parcour): {{$etudiants}}
                </button>
                <a href="{{URL::route('listStudents', $class->id, 1)}}" class="btn btn_warning text-primary">
                    <span class="la la-th-list text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Liste des étudiants ({{$class->short}})
                </a>
            </div>
            @endif
        </div>     
@include('backend.admin.administration.Pay.return')
        <div class="grid lg:grid-cols-4 gap-5 mt-5">
            <!-- Content -->
            <div class="lg:col-span-2 xl:col-span-3">
                <div class="card p-5">
                   <div class="tabs wizard wizard-style-2">
                        <nav class="tab-nav">
                            <button class="nav-link h5 active" data-toggle="tab" data-target="#tab-style-2-0">Etape 1
                                <small>Etat civil</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-1">Etape 2
                                <small>Informations parentale</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-2">
                                Etape 3
                                <small>Information universitaire</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-3">
                                Etape 4
                                <small>Contact et Adresse</small>
                            </button>
                        </nav>
                    {{ Form::open(['route'=>['EtudiantStore', $class->id], 'files'=>'true', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator'])  }}

                            <div class="tab-content mt-8">  
                            <div id="tab-style-2-0" class="flex flex-wrap flex-row -mx-4 collapse open">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="fname">Nom *</label>
                                {{ Form::text('fname', '', ['id'=>'fname', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('fname'))
                                <span class="text-red-700">{{ $errors->first('fname') }}</span>
                                @endif
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="lname">Prénom</label>
                                {{ Form::text('lname', '', ['id'=>'lname', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="sexe">Genre *</label>
                                <div class="custom-select">
                                <select class="form-control" name="sexe" id="sexe">
                                    <option selected disabled>Select</option>
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
                                    <option selected disabled>Select</option>
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
                                {{ Form::text('birth', '', ['id'=>'datepicker', 'class'=>'form-control']) }}
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
                            </div>
                         <div id="tab-style-2-1" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="papa">Père</label>
                                {{ Form::text('papa', '', ['id'=>'papa', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="mama">Mère</label>
                                {{ Form::text('mama', '', ['id'=>'mama', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="jobpapa">Profession père</label>
                                {{ Form::text('jobpapa', '', ['id'=>'jobpapa', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="jobmama">Profession mère</label>
                                {{ Form::text('jobmama', '', ['id'=>'jobmama', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="adresseParent">Adresses parents</label>
                                {{ Form::text('adresseParent', '', ['id'=>'adresseParent', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="contactParent">Contact parents</label>
                                {{ Form::text('contactParent', '', ['id'=>'contactParent', 'class'=>'form-control']) }}
                            </div>
                            </div>
                            <div id="tab-style-2-2" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2 parcours">
                                <label class="label block mb-2" for="parcour_id">Parcours</label>
                                 <div class="custom-select">
                                    <select class="form-control" name="parcour_id" id="parcour_id">
                                          <option value="1">Année Préparatoire</option>
                                    </select>
                            </div>
                            </div>
                            <input type="hidden" class="form-control" name="class_id" id="class" value="{{$class->id }}">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="matricule">Numéro Matricule *</label>
                                <input type="text" name="matricule" value="{{$parcourx->abr.'-'.substr($years->yearsUniv,2,2).'/'.($etudiants+1).'/'.($allStud+1)}}" class="form-control" id="matricule" readonly>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('matricule'))
                                <span class="text-red-700">{{ $errors->first('matricule') }}</span>
                                @endif
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2 groupe">
                                <label class="label block mb-2" for="groupe_id">Groupe</label>
                                 <div class="custom-select">
                                   <select name="groupe_id" id="groupe_id" class="form-control">
                                    <option value="" selected disabled>Choisir</option>
                                   </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="yearsUniv">Année Universitaire *</label>
                                <div class="custom-select">
                                   <select name="yearsUniv" id="yearsUniv" class="form-control">
                                     <option value="{{ $years->yearsUniv }}" selected>{{ $years->yearsUniv }}</option>
                                   </select>
                                   <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('yearsUniv'))
                                <span class="text-red-700">{{ $errors->first('yearsUniv') }}</span>
                                @endif
                            </div>
                            </div>
                            <div id="tab-style-2-3" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 xl:w-1/2">
                                <label class="label block mb-2" for="email">Email</label>
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
                                {{ Form::text('phone_2', ' ', ['id'=>'phone_2', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="facebook">Facebook</label>
                                {{ Form::text('facebook', ' ', ['id'=>'facebook', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/4">
                                <label class="label block mb-2" for="address">Adresse *</label>
                                {{ Form::text('address', ' ', ['id'=>'address', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('address'))
                                <span class="text-red-700">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            </div>
                            </div>
                            <div id="resultajax" class="center"></div>
                            <div class="mt-4">
                             <div class="flex items-center">
                                    <button type="button" class="btn btn_secondary  ltr:ml-3" data-toggle="wizard"
                                        data-direction="previous"><span class="la la-angle-double-left"></span> Préc  
                                    </button>
                                    <button type="button" class="btn btn_primary ltr:ml-1" data-toggle="wizard"
                                        data-direction="next" id="next-btn">Suiv <span class="la la-angle-double-right"></span>
                                    </button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5 dropzone">
                    <label class="input-group font-normal" for="customFile">
                        <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">Fichiers autorisés:pdf,doc,docx,ppt,pptx
                        </div>
                        <input id="customFile" type="file" name="file[]" class="hidden" multiple>
                        <div class="input-group-item btn btn_primary">Parcourir</div>
                    </label>
                </div>
                @if($class->id == 2)
                <div class="flex items-center">
                <div class="w-1/1">
                    <label class="label block">Auditeur Libre?</label>
                </div>
                <div class="w-1/4 ml-2">
                    <label class="label switch">
                        <input type="checkbox" name="grade" value="AL">
                        <span></span>
                        <span>Oui</span>
                    </label>
                </div>
                </div>
                @endif
                <div class="flex flex-wrap gap-2 mt-0">
                    <button type="submit" class="btn btn_success"><span class="la la-plus-circle"></span> Ajouter étudiant</button>
                </div>
            </div>
 {{ Form::close() }}
</div>
 @include('backend.pages.footer')       
</main>   
@stop
