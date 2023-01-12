 <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
@if(Auth::user()->is_admin) 
@if(!Auth::user()->is_secretaire)        
        <!-- Historique -->
        <hr>
         <div class="flex flex-col gap-y-2 p-3">
            <h3 class="p-2">Historiques</h3>
            <hr class="border-dashed">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-user text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#1D4ED8;"></span>
                Ajouté par : 
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$teacher->user->fname}}
               </span>
            </a>
            @if($teacher->created_at !== NULL)
            <a href="#" class="flex items-center text-normal">
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ timeAgo($teacher->created_at) }}
               </span>
            </a>
            @else
            <a href="#" class="flex items-center text-normal">
                <span class="la la-calendar text-2xl leading-none ltr:mr-2 rtl:ml-2" style="color:#1D4ED8;"></span> Date
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $teacher->date_import}}
               </span>
            </a>
            @endif

        </div>
        <hr class="border-dashed">
        @endif 
        @endif

    </aside>


    <!-- Modal FOAD -->
    <div id="foad" class="modal" data-animations="fadeInDown, fadeOutUp">
        <div class="modal-dialog modal-dialog_centered max-w-2xl">
            <div class="modal-content w-full">
                <div class="modal-header">
                    <h3 class="modal-title">Créer accès à distance</h3>
                    <button type="button" class="close la la-times" data-dismiss="modal"></button>
                </div>
             {{ Form::open(['route'=>['takeOnline', $teacher->id], 'class'=>'modal-body', 'autocomplete'=>'off'])  }}    
                <div class="mb-5">
                    <label class="label block mb-2" for="email">E-mail</label>
                    <input id="email" type="email" name="email" value="{{$teacher->email}}" class="form-control" placeholder="{{$teacher->email}}">
                </div>
                <input type="hidden" name="id_teacher"  value="1" class="form-control">
                <input type="hidden" name="fname"       value="{{$teacher->fname}}" class="form-control">
                <input type="hidden" name="lname"       value="{{$teacher->lname}}" class="form-control">
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
                <div class="flex items-center">
                    <button type="submit" class="btn btn_primary ltr:ml-auto rtl:mr-auto uppercase">Céer un compte</button>
                </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>
