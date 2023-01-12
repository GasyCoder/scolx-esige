@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') {{ Lang::get($path.'.new_student') }} @stop
@section('content')
<!-- Workspace -->
<main class="workspace">    
        <!-- Breadcrumb -->
        <section class="breadcrumb">
            <h3>Inscription de l'étudiant - {{$class->short}} <span class="badge badge_outlined badge_danger"><b>Promotion : {{ $promotion->year }}</b></span></h3>
            <ul>
                <li><a href="#">Etudiants</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>Inscription</li>
            </ul>
        </section>  
        <!-- Actions -->
        <div class="card p-3 flex flex-wrap gap-2 breadcrumb breadcrumb_alt">
            @if($class->id == 1)
            <a href="/admin/etudiants/inscription" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @endif
            @if($class->id >= 2)
            <a href="/admin/etudiants/inscription/{{$class->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="custom-select mt-0">
                <select name="select_parcour_name" id="select_parcour_name" onchange="goToNext(this)" class="form-control">
                    @if(!empty($parcour->id))
                    <option value="{{ $parcour->id }}" selected class="font-bold text-primary">{{ $parcour->name }}</option>
                    @else
                    <option value="" selected disabled>--Autre parcours--</option>
                    @endif
                     @foreach($parcours as $parcour)
                        <option value="{{ URL::to('/admin/etudiants/inscription').'/'.$class->id.'/'.$parcour->id}}">{{ $parcour->name }}
                        </option>
                     @endforeach
                </select>
                <div class="custom-select-icon la la-caret-down"></div>
            </div>
            @endif
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
            @if($etudiants > 0)
            @if($class->id == 1)    
                <a href="{{URL::route('sameStudents', [$class->id, $parcour->id])}}" class="btn btn_warning text-primary">
                    <span class="la la-th-list text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Liste étudiants ({{$class->short}})
                </a>
                <a href="{{URL::route('studentsAll')}}" class="btn btn_secondary">
                    <span class="la la-users text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Tous les étudiants
                </a>
             @endif
             @endif     
            @if($etudiants > 0)
            @if($class->id >= 2)    
                <a href="{{URL::route('sameStudents', [$class->id, $parcour->id])}}" class="btn btn_warning text-primary">
                    <span class="la la-th-list text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Liste ajouté
                </a>
                <a href="{{URL::route('studentsAll')}}" class="btn btn_secondary">
                    <span class="la la-users text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Tous les étudiants
                </a>
             @endif
             @endif    
            </div>
           
        </div>     
@include('backend.admin.administration.Pay.return')
        <div class="grid lg:grid-cols-4 gap-5 mt-5">
            <!-- Content -->
            <div class="lg:col-span-2 xl:col-span-3">
                <div class="card p-5">
                   <div class="tabs wizard wizard-style-2">
                        <nav class="tab-nav">
                            <button class="nav-link h5 active" data-toggle="tab" data-target="#tab-style-2-0">Etape 1
                                <small>Informations personnels</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-1">Etape 2
                                <small>Informations parentale</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-3">
                                Etape 3
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
                                <label class="label block mb-2" for="lname">Prénom <small class="">(option)</small></label>
                                {{ Form::text('lname', '', ['id'=>'lname', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="sexe">Sexe *</label>
                                <div class="custom-select">
                                <select class="form-control" name="sexe" id="sexe">
                                    <option selected disabled>--Choisir--</option>
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
                                    <option selected disabled>--Choisir--</option>
                                    <option value="MG">Malagasy</option>
                                    <option value="INDE">Indiens</option>
                                    <option value="FR">Français</option>
                                    <option value="CM">Comoriens</option>
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
                                {{ Form::text('birth', '', ['id'=>'', 'class'=>'form-control', 'placeholder'=>'jj/mm/aaaa']) }}
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
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="nametiteur">Nom de Titeur</label>
                                {{ Form::text('nametiteur', '', ['id'=>'nametiteur', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="jobtiteur">Profession de Titeur</label>
                                {{ Form::text('jobtiteur', '', ['id'=>'jobtiteur', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="adtiteur">Adresses Titeur</label>
                                {{ Form::text('adtiteur', '', ['id'=>'adtiteur', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="ctiteur">Contact Titeur</label>
                                {{ Form::text('ctiteur', '', ['id'=>'ctiteur', 'class'=>'form-control']) }}
                            </div>
                            </div>
                            <input type="hidden" class="form-control" name="parcour_id" id="parcour" value="{{$parcour->id }}">
                             <input type="hidden" name="matricule" value="{{$parcour->abr.''.substr($promotion->year,2,2).'/0'.($etudiants+1).'/esige'}}" class="form-control" id="matricule">
                             <input type="hidden" class="form-control" name="promo" id="class" value="{{ $promotion->year }}">
                            <input type="hidden" class="form-control" name="yearsUniv" id="class" value="{{ $years->yearsUniv }}">

                            <div id="tab-style-2-3" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 xl:w-1/2">
                                <label class="label block mb-2" for="email">Email <small class="">(option)</small></label>
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
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/4">
                                <label class="label block mb-2" for="address">Adresse *</label>
                                {{ Form::text('address', ' ', ['id'=>'address', 'class'=>'form-control']) }}
                                <div class="help-block with-errors"></div>
                                @if($errors->first('address'))
                                <span class="text-red-700">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="phone_2">Téléphone 2 <small class="">(option)</small></label>
                                {{ Form::text('phone_2', ' ', ['id'=>'phone_2', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="facebook">Facebook <small class="">(option)</small></label>
                                {{ Form::text('facebook', ' ', ['id'=>'facebook', 'class'=>'form-control']) }}
                            </div>
                            </div>
                            </div>
                            <div class="mt-4">
                             <div class="flex items-center">
                                    <button type="button" class="btn btn_outlined btn_secondary  ltr:mr-2 rtl:ml-2" data-toggle="wizard"
                                        data-direction="previous"><span class="la la-angle-double-left"></span> Préc  
                                    </button>
                                    <button type="button" class="btn btn_primary ltr:ml-2" data-toggle="wizard"
                                        data-direction="next" id="next-btn">Suivant <span class="la la-angle-double-right"></span>
                                    </button>
                                <p style="margin-left:35rem;color:#0a6c64"><i><u>N.B: Tous les champs avec <b>*</b> sont obligatoire.</u></i></p>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-5 lg:col-span-2 xl:col-span-1">
                <!-- Publish -->
                <div class="card p-5 flex flex-col gap-y-5 dropzone">
                    <label class="input-group font-normal" for="customFile">
                        <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">Sélectionner fichier : PDF
                        </div>
                        <input id="customFile" type="file" name="file[]" class="hidden" multiple>
                        <div class="input-group-item btn btn_primary"><span class="la la-upload text-xl leading-none"></span>Parcourir</div>
                    </label>
                </div>
                @if($class->id == 2)
                <div class="flex items-center">
                <div class="w-1/1">
                    <label class="label block text-xl">Auditeur Libre?</label>
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
                    <button type="submit" class="btn btn_success"><span class="la la-plus-circle text-xl leading-none"></span> Ajouter étudiant</button>
                </div>
                <hr class="border-dashed">
                <!-- Tags -->
                <div class="breadcrumb breadcrumb_alt">
                    <div class="flex flex-col gap-y-5 p-5">
                        <h3 class="">Compteur</h3>
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-user-plus text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            Inscrit sur cette class et parcour
                            <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$etudiants}}</span>
                        </a>
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-users text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                            Total étudiants inscrit
                            <span class="badge badge_outlined badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$allStud}}</span>
                        </a>
                    </div>
                </div>

            </div>
 {{ Form::close() }}
</div>
 @include('backend.pages.footer')  
 @section('js')
<script type="text/javascript">
 var urlmenu = document.getElementById( 'select_parcour_name' );
 urlmenu.onchange = function() {
      window.open( this.options[ this.selectedIndex ].value, '_self');
 };
</script>
@endsection     
</main>   
@stop
