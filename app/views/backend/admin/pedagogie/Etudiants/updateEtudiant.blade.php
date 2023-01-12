@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Modifier {{ $student->fname.' '.$student->lname }} @stop
@section('content')
@include('backend.timeAgo')
    <!-- Workspace -->
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb">
 <!-- Breadcrumb -->
        <section class="breadcrumb">
            <h2>Modifier - <code class="text-primary">{{ $student->fname }} {{ $student->lname }}</code></h2>
            <ul>
                <li><a href="#">Etudiants</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Modifier étudiant</li>
            </ul>
        </section> 
        </section>
        <div class="card p-3 flex flex-wrap gap-2 breadcrumb breadcrumb_alt">
             <a href="{{URL::route('profileEtudiant', [$class->id, $parcour->id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}" class="btn btn_primary">
                <span class="la la-user text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Profile de l'étudiant
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <a href="{{URL::route('sameStudents', [$class->id, $parcour->id])}}" class="btn btn_warning text-primary">
                    <span class="la la-th-list text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Liste même niveau et parcours
                </a>
           
                <a href="{{URL::route('studentsAll')}}" class="btn btn_secondary">
                    <span class="la la-users text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Tous les étudiants
                </a>
            </div>
        </div>   
       @include('backend.admin.administration.Pay.return')
        <div class="grid lg:grid-cols-2 gap-5 mt-5">
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

{{ Form::open(['route'=>['updateStudent', $student->id], 'class'=>'', 'id'=>'', 'data-toggle'=>''])  }}  

                            <div class="tab-content mt-8">  
                            <div id="tab-style-2-0" class="flex flex-wrap flex-row -mx-4 collapse open">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="fname">Nom *</label>
                                {{ Form::text('fname', $student->fname, ['id'=>'fname', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="lname">Prénom</label>
                                {{ Form::text('lname', $student->lname, ['id'=>'lname', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="sexe">Genre *</label>
                                <div class="custom-select">
                                 <select class="form-control" name="sexe" id="sexe">
                                    <option selected disabled>Select</option>
                                    @if($instances->sexe == 1)
                                    <option value="1" selected="selected" class="font-bold">Homme</option>
                                    <option value="2">Femme</option>
                                    @elseif($instances->sexe == 2)
                                    <option value="2" selected="selected" class="font-bold">Femme</option>
                                    <option value="1">Homme</option>
                                    @else
                                    <option value="1">Homme</option>
                                    <option value="2">Femme</option>
                                    @endif
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="nationality">Nationalité *</label>
                                <div class="custom-select">
                                 <select class="form-control" name="nationality" id="nationality">
                                    <option selected disabled>Select</option>
                                    @if($instances->nationality == 'MG')
                                    <option value="MG" selected class="font-bold">Malagasy</option>
                                    <option value="FR">Français</option>
                                    <option value="INDE">Indiens</option>
                                    <option value="CM">Comoriens</option>
                                    @elseif($instances->nationality == 'FR')
                                    <option value="FR" selected class="font-bold">Français</option>
                                    <option value="MG">Malagasy</option>
                                    <option value="INDE">Indiens</option>
                                    <option value="CM">Comoriens</option>
                                    @elseif($instances->nationality == 'INDE')
                                    <option value="INDE" selected class="font-bold">Indiens</option>
                                    <option value="MG">Malagasy</option>
                                    <option value="FR">Français</option>
                                    <option value="CM">Comoriens</option>
                                    @elseif($instances->nationality == 'CM')
                                    <option value="CM" selected class="font-bold">Comoriens</option>
                                    <option value="MG">Malagasy</option>
                                    <option value="FR">Français</option>
                                    <option value="INDE">Indiens</option>
                                    @else
                                    <option value="MG">Malagasy</option>
                                    <option value="FR">Français</option>
                                    <option value="INDE">Indiens</option>
                                    <option value="CM">Comoriens</option>
                                    @endif
                                </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="birth">Date de naissance *</label>
                                {{ Form::text('birth', $student->birth, ['id'=>'', 'class'=>'form-control', 'placeholder'=>'jj/mm/aaaa']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="birthLocation">Lieu de naissance *</label>
                                 {{ Form::text('birthLocation', $student->birthLocation, ['id'=>'birthLocation', 'class'=>'form-control']) }}
                            </div>
                            </div>
                            <div id="tab-style-2-1" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="papa">Père</label>
                                {{ Form::text('papa', $parents->papa, ['id'=>'papa', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="mama">Mère</label>
                                {{ Form::text('mama', $parents->mama, ['id'=>'mama', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="jobpapa">Profession père</label>
                                {{ Form::text('jobpapa', $parents->jobpapa, ['id'=>'jobpapa', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="jobmama">Profession mère</label>
                                {{ Form::text('jobmama', $parents->jobmama, ['id'=>'jobmama', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="adresseParent">Adresses parents</label>
                                {{ Form::text('adresseParent', $parents->adresseParent, ['id'=>'adresseParent', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="contactParent">Contact parents</label>
                                {{ Form::text('contactParent', $parents->contactParent, ['id'=>'contactParent', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="nametiteur">Nom de Titeur</label>
                                {{ Form::text('nametiteur', $parents->nametiteur, ['id'=>'nametiteur', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="ctiteur">Contact titeur</label>
                                {{ Form::text('ctiteur', $parents->ctiteur, ['id'=>'ctiteur', 'class'=>'form-control']) }}
                            </div>
                             <div class="mb-5 flex-shrink px-4 w-full xl:w-2/2">
                                <label class="label block mb-2" for="adtiteur">Adresses titeur</label>
                                {{ Form::text('adtiteur', $parents->adtiteur, ['id'=>'adtiteur', 'class'=>'form-control']) }}
                            </div>
                            </div>
                            <div id="tab-style-2-2" class="flex flex-wrap flex-row -mx-4 collapse">
                            @if($class->id == 1)
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2 parcours">
                                <label class="label block mb-2" for="parcour_id">Parcours</label>
                                 <div class="custom-select">
                                    <select class="form-control" name="parcour_id" id="parcour_id">
                                          <option value="1">Année Préparatoire</option>
                                    </select>
                            </div>
                            </div>
                            @else
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="class_id">Niveau *</label>
                                 <div class="custom-select">
                                   <select name="class_id" id="class_id" class="form-control">
                                    @if(!empty($student->class_id))
                                    <option value="{{ $student->class_id }}" selected class="font-bold text-red-700">{{ $student->niveau->name }}</option>
                                    @else
                                    <option value="" selected disabled>Choisir</option>
                                    @endif
                                     @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                     @endforeach
                                   </select>
                                </div>
                            </div>   
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2 parcours">
                                <label class="label block mb-2" for="parcour_id">Parcours *</label>
                                 <div class="custom-select">
                                   <select class="form-control" name="parcour_id" id="parcour_id">
                                        @if(!empty($student->parcour_id))
                                        <option value="{{$student->parcour_id}}" selected class="font-bold text-primary">{{ $student->parcour->name }}</option>
                                        @else
                                        <option value="" selected disabled>Choisir</option>
                                        @endif
                                        @foreach($parcours as $parcour)
                                          <option value="{{ $parcour->id }}">{{ $parcour->name }}</option>
                                        @endforeach
                                    </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                                <div class="help-block with-errors"></div>
                                @if($errors->first('parcour_id'))
                                <span class="text-red-700">{{ $errors->first('parcour_id') }}</span>
                                @endif
                            </div>
                            </div>
                            @endif 

                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="matricule">Numéro Matricule *</label>
                               {{ Form::text('matricule', $student->matricule, ['id'=>'matricule', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('matricule'))
                                <span class="text-red-700">{{ $errors->first('matricule') }}</span>
                                @endif
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2 groupe">
                                <label class="label block mb-2" for="groupe_id">Groupe</label>
                                 <div class="custom-select">
                                    <select name="groupe_id" id="groupe_id" class="form-control" disabled>
                                      @if(!empty($student->groupe_id))
                                        <option value="{{$student->groupe_id}}" selected="" class="font-bold">{{$student->groupe->name}}</option>
                                      @else
                                      <option selected disabled>Choisir</option>
                                      @endif
                                      @foreach($groupes as $groupe)
                                         <option value="{{ $groupe->id }}">{{ $groupe->name }}</option>
                                      @endforeach
                                   </select>
                                    <div class="custom-select-icon la la-caret-down"></div>
                                </div>
                            </div>
                           
                            </div>
                            <div id="tab-style-2-3" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 xl:w-1/2">
                                <label class="label block mb-2" for="email">Email (option)</label>
                                {{ Form::email('email', $student->email, ['id'=>'email', 'class'=>'form-control']) }}
                                <span class="block emailError text-red-500 text-xs  hidden">error</span>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="phone_1">Téléphone 1 *</label>
                                {{ Form::text('phone_1', $student->phone_1, ['id'=>'phone_1', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/4">
                                <label class="label block mb-2" for="address">Adresse *</label>
                                {{ Form::text('address', $student->address, ['id'=>'address', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="phone_2">Téléphone 2</label>
                                 {{ Form::text('phone_2', $student->phone_2, ['id'=>'phone_2', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="facebook">Facebook</label>
                                {{ Form::text('facebook',  $parents->facebook, ['id'=>'facebook', 'class'=>'form-control']) }}
                            </div>
                            </div>
                            </div>
                            <div class="mt-4">
                             <div class="flex items-center">
                                    <button type="button" class="btn btn_secondary  ltr:ml-3" data-toggle="wizard"
                                        data-direction="previous"><span class="la la-angle-double-left"></span> Préc  
                                    </button>
                                    <button type="button" class="btn btn_primary ltr:ml-1" data-toggle="wizard"
                                        data-direction="next" id="next-btn">Suiv <span class="la la-angle-double-right"></span>
                                    </button>
                            </div>
                            <center>
                                    <button type="submit" class="btn btn_success"><span class="la la-sync"></span> Mettre à jour</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
         {{ Form::close() }}           
        </div> 
@include('backend.pages.footer')      
    </main>   
@stop
