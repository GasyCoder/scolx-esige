 <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Status -->
        <h3 class="p-4">Situations</h3>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-user-graduate text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:blue;"></span>
                Niveau:
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                {{$class->name}}
                @if($profile->grade == 'AL') - Mixte
                @endif
                </span> 
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-graduation-cap text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:blue;"></span>
                Promotion:
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                {{$instance->promo}}
                </span> 
            </a>
            @if($profile->groupe_id >0)
            <a href="#!" class="flex items-center text-normal">
                <span class="la la-users text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#F97316;"></span>
                Groupe
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto"> {{$instance->groupe->name}}</span>
            </a>
            @endif
        </div>
@if(Auth::user()->is_admin) 
@if(!Auth::user()->is_secretaire)        
        <!-- Historique -->
        <hr>
         <div class="flex flex-col gap-y-2 p-5">
            <h3 class="p-2">Trace</h3>
            <hr class="border-dashed">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-user text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#1D4ED8;"></span>
                Ajouté par : 
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$instance->user->fname}}
               </span>
            </a>
            @if($profile->created_at !== NULL)
            <a href="#" class="flex items-center text-normal">
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    <i class="la la-clock"></i> {{ timeAgo($profile->created_at) }}
               </span>
            </a>
            @endif
            <a href="#" class="flex items-center text-normal">
                <span class="la la-user text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#1D4ED8;"></span>
                Modifié par : 
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$instance->user->fname}}</span>
            </a>
            @if($profile->updated_at !== NULL)
            <a href="#" class="flex items-center text-normal">
                <span class="badge badge_outlined badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                    <i class="la la-clock"></i> {{ timeAgo($profile->updated_at) }}
               </span>
            </a>
            @endif
        </div>
        <hr class="border-dashed">
        @endif 
        @endif
        @if(!empty($fichier->jointe)) 
        <?php $one_file = explode(",", $fichier->jointe); ?>
        <h3 class="p-5">Fichiers jointe <code>({{count($one_file)}})</code></h3>
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
            <a href="{{url()}}/uploads/files_students/{{$fichier->jointe}}" target="_blank" class="flex items-center text-normal">
            <span class="la la-paperclip text-2xl leading-none ltr:mr-2 rtl:ml-2 text-primary"></span>
            <span class="text-primary">{{$fichier->jointe}}</span>
            <a onclick="return confirm('Vous voulez supprimer?')" href="{{ URL::route('supfile', $profile->id)}}" class="badge badge_outlined badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
            <span class="la la-trash text-sm"></span>
            </a>
            </a>
        </div>
      @endif
      <hr>
    @if($fichier->jointe > 0)      
    <div class="flex flex-col gap-y-5 p-5">
    @if($fichier->otherFile > 0)
    <h4>Autre fichier</h4>
    <a href="{{url()}}/uploads/autre_files_students/{{$fichier->otherFile}}" target="_blank" class="flex items-center text-normal">  
        <span class="la la-paperclip text-2xl leading-none ltr:mr-2 rtl:ml-2 text-primary"></span>
        <span class="text-primary">{{$fichier->otherFile}}</span>
        <a onclick="return confirm('Vous voulez supprimer?')" href="{{ URL::route('supotherfile', $profile->id)}}" class="badge badge_outlined badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
            <span class="la la-trash text-sm"></span>
         </a>
    </a>
    @endif
    </div>
    {{ Form::open(['route'=>['otherFile', $profile->id], 'files'=>'true', 'class'=>'mt-3'])  }}  
        <div class="p-5 flex flex-col gap-y-5 dropzone">
        <label class="input-group font-normal" for="customFile">
                <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">
                    Fichiers autorisés: PDF
                </div>                            
                <input name="otherFile" id="customFile" type="file" class="hidden">
                <button type="submit" class="input-group-item badge badge_info"><span class="la la-cloud-upload-alt text-xl"></span> Uploader</button> 

        </label>
        </div>
    {{ Form::close() }} 
    @endif
    </aside>
