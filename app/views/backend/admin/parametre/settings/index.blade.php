@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') {{ Lang::get($path.'.settings') }} @stop
@section('content')
{{ HTML::style('public/inputTags/css/inputTags.css') }}
{{ HTML::script('public/inputTags/js/inputTags.jquery.js') }}
<!-- Workspace -->
<main class="workspace">
<section class="breadcrumb">        
@include('backend.break')
</section>
@include('backend.pages.alerts')
<div id="resultajax"></div>
 <!-- Accordion -->
            <div class="card p-5">
                <div class="accordion rounded-xl">
                    <h5 class="p-5 active" data-toggle="collapse" data-target="#accordion">
                        <span class="la la-cog text-xl"></span> Paramètres généraux #1
                        <span class="collapse-indicator la la-arrow-circle-down"></span>
                    </h5>
                    <div id="accordion" class="collapse">
{{ Form::open(['route'=>'settingsOne', 'method'=>'POST']) }}                    	
                    <div class="input-group mt-2">
                    	<div class="mb-5 flex-shrink px-4 w-full">
                         <label class="label block mb-2" for="school_name">Nom de l'Université</label>
                        <input type="text" name="school_name" value="{{ $control->school_name }}" class="form-control w-full">
                         </div>
                        <div class="mb-5 px-4">
                         <label class="label block mb-2" for="sigle">Sigle</label>
                        <input type="text" name="sigle" value="{{ $control->sigle }}" class="form-control flex flex-row xl:col-span-1">
                         </div>
                        <div class="mb-5 px-4 flex-shrink">
                         		<label class="label block mb-2" for="slogan">Slogan</label>
                        		<input type="text" name="slogan" value="{{ $control->slogan }}" class="form-control">
                        </div>
                    </div>
                     <div class="flex flex-wrap flex-row -mx-4">
                     	<div class="mb-5 flex-shrink px-4 w-full xl:w-1/3">
                                <label class="label block mb-2" for="address">Adresses</label>
                                <input type="text" name="address" value="{{ $control->address }}" class="form-control">
                          </div>
	                        <div class="mb-5 px-4 w-full xl:w-1/3">
	                         <label class="label block mb-2" for="phone">Tél</label>
	                        <input type="text" name="phone" alue="{{ $control->phone }}" class="form-control flex flex-row xl:col-span-1">
	                         </div>
	                        <div class="mb-5 px-4 w-full xl:w-1/3">
	                         <label class="label block mb-2" for="email">Email</label>
	                        <input type="email" name="email" value="{{ $control->email }}" class="form-control">
	                        </div>

	                        <div class="mb-5 px-4 w-full">
	                         <label class="label block mb-2" for="desc">Descriptions</label>
	                        <textarea name="description" class="form-control" rows="3">{{ $control->description }}</textarea>
	                        </div>
                      </div>
                      		<div class="flex flex-wrap flex-row -mx-4">
                     			<div class="mb-5 flex-shrink px-4 w-full xl:w-1/3">
                                <label class="label block mb-2" for="facebook">Facebook</label>
                                <input type="text" name="facebook" value="{{ $control->facebook }}" class="form-control">
                          	</div>
	                        <div class="mb-5 px-4 w-full xl:w-1/3">
	                         <label class="label block mb-2" for="twitter">Twitter</label>
	                        <input type="text" name="twitter" value="{{ $control->twitter }}" class="form-control flex flex-row xl:col-span-1">
	                         </div>
	                        <div class="mb-5 px-4 w-full xl:w-1/3">
	                         <label class="label block mb-2" for="youtube">Youtube</label>
	                        <input type="text" name="youtube" value="{{ $control->youtube }}" class="form-control">
	                        </div>
                      		</div>
							<div class="mb-3">
                             <div class="flex items-center">
                                 <button type="submit" class="btn btn_primary uppercase ltr:ml-auto rtl:mr-0">Mettre à jour</button>
                            </div> 
                             <br>
                        </div>
{{ Form::close() }}
                    </div>

                    <h5 class="border-t border-divider p-5" data-toggle="collapse" data-target="#accordion-2">
                        <span class="la la-sitemap text-xl"></span> Paramètres SEO #2
                        <span class="collapse-indicator la la-arrow-circle-down"></span>
                    </h5>
                    <div id="accordion-2" class="collapse">                       
                     <div class="flex flex-wrap flex-row -mx-4">                                               
                     	 <div class="mb-5 px-4 w-full">
	                         <label class="label block mb-2" for="desc">Mots clés</label>
                                    <span class="flex items-center ltr:pl-0 rtl:pr-0">
                                        @foreach($keywords as $keyword)
                                        <span class="badge badge_primary badge_outlined font-bold">
                                         {{ $keyword->the_keywords }}
                                        <a href="{{ URL::route('deletekeywords', $keyword->id) }}" class="badge badge_danger ltr:ml-2 rtl:mr-1 la la-times"></a>
                                        </span>
                                        @endforeach
                                    </span>
{{ Form::open(['route'=>'keyWords', 'class'=>'', 'id'=>'myForm', 'data-toggle'=>'validator'])  }}
                            <div class="input-group mt-5">
		                        <input type="text" name="the_keywords" class="form-control input-group-item" placeholder="Tapez ici les mots clés et separé par ,">
		                        <button type="submit" class="btn btn_primary input-group-item">Ajouter</button>
		                    </div>
                          {{ Form::close() }}
@include('backend.admin.parametre.settings.ajaxAdd')                              
                    	  </div>                 
	                      <div class="mb-5 flex-shrink px-4 w-full xl:w-1/3">
	                          <label class="label block mb-2" for="address">Sitemap</label>
	                           <div class="w-full" style="padding-left:5px; padding-bottom: 5px; margin-top: 5px; background-color: #f9f9f9;">
						          <a style="color: #c55;" href="{{ url() }}/sitemap.xml">{{ url() }}/sitemap.xml</a>
						      </div>
	                       </div>                                                    
                      </div>                       
                    </div>
                    <h5 class="border-t border-divider p-5" data-toggle="collapse" data-target="#accordion-3">
                      <span class="la la-lock text-xl"></span> Sécurités
                       <span class="collapse-indicator la la-arrow-circle-down"></span>
                    </h5>
 					<div id="accordion-3" class="collapse">
                   <div class="grid lg:grid-cols-3 gap-5">                    
{{ Form::open(['route'=>'update_admin', 'files'=>'true', 'class'=>'', 'method'=>'POST']) }}                    
	            	<div class="flex flex-col gap-y-5 lg:col-span-1">
	                <!-- Basic -->
	                <div class="card p-5">
	                    <h4><span class="la la-user-shield text-xl"></span> Accès Admin</h4>
	                    <div class="input-group mt-5">
	                        <div class="input-addon input-addon-prepend input-group-item">@</div>
	                        {{ Form::email('email', $user->email, ['placeholder'=>'', 'class'=>'form-control input-group-item', 'data-error'=>'Adresse email invalide']) }} 
	                    </div>
	                     <label class="input-group mt-5 font-normal" for="customFile">
                            <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">No file chosen</div>
                            <input id="customFile" name="image" type="file" class="hidden">
                            <div class="input-group-item btn btn_primary">Changer photo</div>
                        </label>
                        <div class="avatar w-20 h-20 mt-5">
                            @if(!empty($user->image))
		                        <?php echo HTML::image('uploads/profiles/'.$user->image.'', '', ['class'=>'', 'width'=>'', 'height'=>'']) ?>
		                    @endif
                        </div>
						<div class="mb-3">
                         <div class="flex items-center">
                         <button type="submit" class="btn btn_success ltr:ml-auto rtl:mr-0">Mettre à jour</button>
                        </div> 
                       </div>
	                </div>
	                </div>
   
{{ Form::close() }} 
{{ Form::open(['route'=>'admin_password', 'class'=>'flex flex-col gap-y-5 lg:col-span-2', 'method'=>'POST']) }}
                <div class="card p-5">
                    <h4><span class="la la-key text-xl"></span> Changer mot de passe</h4>
                    <div class="input-group mt-5">
                        <input type="password" name="old_password" class="form-control input-group-item" placeholder="Ancien mot de passe" required>
                        <input type="password" name="password" class="form-control input-group-item" placeholder="Nouveau mot de passe" required>
                        <input type="password" name="password_confirm" class="form-control input-group-item" placeholder="Confirmer mot de passe" required>
                    </div>
                </div>
				<div class="mb-3">
                 <div class="flex items-center">
                 <button type="submit" class="btn btn_danger ltr:ml-auto rtl:mr-0">Confirmer</button>
                </div> 
                </div>                
{{ Form::close() }}             	             	
            </div>
          </div>
        </div>
</main>
@include('backend.admin.parametre.settings.aside')
    <!-- Centered -->
    <div id="siteDisabled" class="modal" data-animations="fadeInDown, fadeOutUp">
        <div class="modal-dialog modal-dialog_centered max-w-2xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-red-700">Hey, Etes-vous sur pour desactiver votre application?</h3>
                    <button type="button" class="close la la-times" data-dismiss="modal"></button>
                </div>
                 
                <div class="modal-body">
                    <p class="text-xl mb-2">Votre application séra desactiver si vous accptez et ce en bas messages s'apparaîtrais</p>
                    <p class="font-bold text-center text-xl"><u>{{ $control->closing_msg }}</u></p>
                {{ Form::open(['route'=>'closeApp', 'class' => 'flex flex-col gap-y-2 mb-5', 'method'=>'POST']) }} 
                <br>   
                        <label class="custom-radio">
                        	@if($control->close_site == 1)
                            {{ Form::radio('close_site', true, ['checked'=>'checked']) }}
                            <span></span>
                            <span>Oui</span>
                            @else
                            {{ Form::radio('close_site', true) }}
                            <span></span>
                            <span>Oui</span>
                            @endif
                        </label>
                        <label class="custom-radio">
                        	@if($control->close_site == 0)
                            {{ Form::radio('close_site', false, ['checked'=>'checked']) }}
                            <span></span>
                            <span>Non</span>
                            @else
                            {{ Form::radio('close_site', false) }}
                            <span></span>
                            <span>Non</span>
                            @endif
                        </label>
                         <div class="modal-footer">
	                    <div class="flex ltr:ml-auto rtl:mr-auto">
	                        <button type="button" class="btn btn_secondary uppercase" data-dismiss="modal">Annuler</button>
	                        <button type="submit" class="btn btn_danger ltr:ml-2 rtl:mr-2 uppercase"><span class="la la-exclamation-triangle text-xl"></span> Oui accepter</button>
	                    </div>
	                {{ Form::close() }}     
                </div>
                </div>
            </div>
        </div>
    </div>    
@stop