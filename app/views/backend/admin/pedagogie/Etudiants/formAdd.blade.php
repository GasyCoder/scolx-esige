<!-- Modal Add -->
    <div id="add" class="modal" data-animations="fadeInDown, fadeOutUp" data-static-backdrop>
        <div class="modal-dialog modal-dialog_centered max-w-2xl">
            <div class="modal-content w-full">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter nouveau étudiant</h4>
                    <button type="button" onclick="refresh();" class="close la la-times" data-dismiss="modal"></button>
                </div>
           <div class="modal-body"> 
                    <div class="tabs wizard wizard-style-2">
                        <nav class="tab-nav">
                            <button class="nav-link h5 active" data-toggle="tab" data-target="#tab-style-2-1">
                                Etape 1
                                <small>Etat civil</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-2">
                                Etape 2
                                <small>Information universitaire</small>
                            </button>
                            <button class="nav-link h5" data-toggle="tab" data-target="#tab-style-2-3">
                                Etape 3
                                <small>Contact et Adresse</small>
                            </button>
                        </nav>

{{ Form::open(['route'=>['EtudiantStore', $class->id], 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator'])  }}

                            <div class="tab-content mt-8">  
                            <div id="tab-style-2-1" class="flex flex-wrap flex-row -mx-4 collapse open">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="fname">Nom *</label>
                                {{ Form::text('fname', '', ['id'=>'fname', 'class'=>'form-control']) }}
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
                                </div>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="birth">Date de naissance *</label>
                                {{ Form::text('birth', '', ['id'=>'datepicker', 'class'=>'form-control']) }}
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="birthLocation">Lieu de naissance *</label>
                                <input type="text-center" id="birthLocation" name="birthLocation" class="form-control">
                            </div>
                            </div>
                            <div id="tab-style-2-2" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2 parcours">
                                <label class="label block mb-2" for="parcour_id">Parcours *</label>
                                 <div class="custom-select">
                                    <select class="form-control" name="parcour_id" id="parcour_id">
                                        <option value="" selected disabled>Choisir</option>
                                         @foreach($parcours as $parcour)
                                          <option value="{{ $parcour->id }}">{{ $parcour->name }}</option>
                                         @endforeach
                                    </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                            </div>

                             <input type="hidden" class="form-control" name="class_id" id="class" value="{{$class->id }}">
                             
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="matricule">Numéro Matricule *</label>
                                {{ Form::text('matricule', '', ['id'=>'matricule', 'class'=>'form-control']) }}
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
                                    <option value="" selected disabled>Choisir</option>
                                     @foreach($years as $year)
                                     <option value="{{ $year->yearsUniv }}">{{ $year->yearsUniv }}</option>
                                    @endforeach
                                   </select>
                                </div>
                            </div>
                            </div>
                            <div id="tab-style-2-3" class="flex flex-wrap flex-row -mx-4 collapse">
                            <div class="mb-5 flex-shrink px-4 xl:w-1/2">
                                <label class="label block mb-2" for="email">Email</label>
                                {{ Form::email('email', '', ['id'=>'email', 'class'=>'form-control']) }}
                                <span class="block emailError text-red-500 text-xs  hidden">error</span>
                            </div>
                            <div class="mb-5 flex-shrink px-4 w-full xl:w-1/2">
                                <label class="label block mb-2" for="phone_1">Téléphone 1 *</label>
                                {{ Form::text('phone_1', '', ['id'=>'phone_1', 'class'=>'form-control']) }}
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

                                    <button type="submit" class="btn btn_success ltr:ml-auto rtl:mr-0"> <span class="la la-plus-circle text-xl"></span>Ajouter</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
         {{ Form::close() }}
@include('backend.admin.pedagogie.Etudiants.ajaxadd')          
        </div>
       </div> 
      </div>
@section('js')
  
@endsection    