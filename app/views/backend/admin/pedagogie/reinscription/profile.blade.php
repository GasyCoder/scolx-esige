 <style type="text/css">
.choose_file{
    position:relative;
    display:inline-block;    
    border-radius:8px;
    border:#ebebeb solid 1px;
    width:100px; 
    padding: 2px 3px 2px 4px;
    font: normal 14px Myriad Pro, Verdana, Geneva, sans-serif;
    color: #7f7f7f;
    margin-top:1px;
    background:white
}
.choose_file input[type="file"]{
    -webkit-appearance:none; 
    position:absolute;
    top:0; left:0;
    opacity:0; 
}
 </style> 
            <div class="lg:col-span-2 xl:col-span-1">
            <div class="card p-5">
                <div class="status bg-success"></div>
                <center>
            <div class="image">  
            {{ Form::open(['route'=>['pdpStudent', $profile->id], 'files'=>'true', 'class'=>'mt-1'])  }}      
                @if(!empty($fichier->image))
                <?php echo HTML::image('uploads/profiles/students/'.$fichier->image.'', '', ['class'=>'ronded', 'width'=>'180','height'=>'80']) 
                ?>
                @elseif($instance->sexe == 1)
                    {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                    @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'50']) }}
                @endif
                <div class="choose_file">
                    <span>Parcourir</span>
                    <input name="image" type="file" />
                </div>            
                <br>
                <button type="submit" class="input-group-item badge badge_secondary"><span class="la la-cloud-upload-alt text-sm"></span></button>
                <a onclick="return confirm('Vous voulez supprimer?')" href="{{ URL::route('deletePdp', $profile->id)}}" class="input-group-item badge badge_danger"><span class="la la-trash text-sm"></span></a> 
            {{ Form::close() }}  
            </div>
        </center>
                    <div class="border-t border-dashed mt-2">
                        <h5>{{$profile->fname}} {{$profile->lname}}</h5>
                        <i><span>Sexe:</span>@if($instance->sexe == 1) Homme @else Femme @endif - Nationalité: @if($instance->nationality == 0) Malagasy @elseif($instance->nationality == 1) Français @else Comoriens @endif</i>
                    </div>
                    <div class="mt-2 leading-normal">
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-birthday-cake text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                           <h6></h6>{{$profile->birth}} à {{$profile->birthLocation}}
                        </a>
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-id-badge text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                            <h6></h6>{{$profile->matricule}}
                        </a>
                        <hr class="border-dashed">
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-phone text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                            <h6></h6> {{$profile->phone_1}}
                        </a>
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-at text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                            <h6></h6> {{$profile->email}}
                        </a>
                        @if($profile->facebook > 0)
                         <a href="#" class="flex items-center text-normal">
                            <span class="la la-facebook text-muted text-1xl ltr:mr-0 rtl:ml-0"></span>
                            {{$profile->facebook}}
                        </a>
                        @else
                        @endif
                        <hr class="border-dashed">
                        <a href="#" class="flex items-center text-normal">
                            <span class="la la-map-marked-alt text-muted text-2xl ltr:mr-0 rtl:ml-0"></span>
                            {{$profile->address}}
                        </a>
                        <hr class="border-dashed">
                        <center>
                        {{ QrCode::encoding("UTF-8")->size(130)->generate(
                        'Nom:'.         ' ' .$profile->fname. ' | ' 
                        .'Prenom:'.     ' ' .$profile->lname. ' | ' 
                        .'Classe:'.     ' ' .$class->short. '-' .$parcour->abr. ' | ' 
                        .'Promotion:'.  ' ' .$profile->promo. ' | ' 
                        .'Ecole:'.      ' ' .'ESIGE MAHAJANGA');
                        }}
                        </center>
                        <hr>
                        @if(!empty($fichier->jointe))
                        @else
                        <center><h4 class="text-center mt-3 badge badge_danger"><span class="icon la la-folder"></span> Dossiers incomplète</h4></center>
                        @endif
                    </div>
                </div>
                @if(empty($fichier->jointe))
                {{ Form::open(['route'=>['uploader_file', $fichier->id], 'files'=>'true', 'class'=>'mt-3'])  }} 
                <div class="card p-5 flex flex-col gap-y-5 dropzone">
                    <h4>Ajouter fichier</h4>
                    <label class="input-group font-normal" for="customFile">
                            <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">
                                Fichiers autorisés: PDF
                            </div>
                            <input id="customFile" type="file" name="jointe" class="hidden">
                            <button type="submit" class="input-group-item badge badge_secondary"><span class="la la-cloud-upload-alt text-xl"></span> Uploader</button> 
                    </label>
                </div>
                {{ Form::close() }} 
                @endif
            </div>  