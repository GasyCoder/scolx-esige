<!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tabs -->
        <div class="tabs p-2">
            <nav class="tab-nav mt-2 p-5">
                <button class="nav-link h5 active" data-toggle="tab" data-target="#tab-1"><span class="la la-tools"></span>Réglages</button>
                <button class="nav-link h5" data-toggle="tab" data-target="#tab-2"><span class="la la-image"></span>Logo/Favicon</button>
            </nav>
            <div class="tab-content mt-0">
            <!-- réglages -->
            <div id="tab-1" class="collapse open">
             <div class="overflow-y-auto">
            <br>
{{ Form::open(['route'=>'nombreMois', 'method'=>'POST']) }}     
            <p class="px-2 flex justify-between py-0">Nombre du mois</p>    
            <div class="input-group px-2">
                <input type="text" name="nbre_mois" value="{{ $control->nbre_mois }}" class="form-control input-group-item" placeholder="Nombre du mois pendant une année universitaire">
                <button type="submit" class="badge badge_primary input-group-item">Valider</button>
            </div>
{{ Form::close() }}
 </div>      
<br>
<div class="overflow-y-auto">
{{ Form::open(['route'=>'activeRemise', 'method'=>'POST']) }}         
            <hr class="border-dashed">
                <p class="px-2 flex justify-between py-0">Remise %</p>
                <div class="input-group px-2">
                    <input type="text" name="remise" value="{{ $control->remise }}" width="0.3rem" class="form-control input-group-item">
                    <button type="submit" class="badge badge_primary input-group-item">Valider</button>
                </div>
                <label class="label switch px-2 flex justify-between py-0 mt-2">
                @if($control->activeRemise == 0)    
                <input type="checkbox" name="activeRemise" value="1">
                <span></span>
                <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                @else
                <input type="checkbox" name="activeRemise" checked value="0">
                <span></span>
                <span><button type="submit" class="badge badge_success">Activé</button></span>
                @endif
                </label>
{{ Form::close() }}                
                <hr class="my-2 border-dashed">
{{ Form::open(['route'=>'activeTax', 'method'=>'POST']) }}                
                <p class="px-2 flex justify-between py-0">Tax %</p>
                <div class="input-group px-2">
                    <input type="text" name="payment_tax" value="{{ $control->payment_tax }}" width="0.3rem" class="form-control input-group-item">
                    <button type="submit" class="badge badge_primary input-group-item">Valider</button>
                </div>
                <label class="label switch px-2 flex justify-between py-0 mt-2">
                @if($control->activeTax == 0)    
                <input type="checkbox" name="activeTax" value="1">
                <span></span>
                <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                @else
                <input type="checkbox" name="activeTax" checked value="0">
                <span></span>
                <span><button type="submit" class="badge badge_success">Activé</button></span>
                @endif
                </label>
{{ Form::close() }} 
{{ Form::open(['route'=>'paymentUnit', 'method'=>'POST']) }}               
                <hr class="my-4 border-dashed">
                <p class="px-2 flex justify-between py-0">Unité d'argent</p>
                <div class="input-group px-2">
                    <input type="text" name="payment_unit" value="{{ $control->payment_unit }}" width="0.3rem" class="form-control input-group-item">
                    <button type="submit" class="badge badge_primary input-group-item">Valider</button>
                </div>
            </div>
{{ Form::close() }} 
<br>   
<div style="background-color:#F7FEE7">
<hr class="border-dashed">
<div class="mt-1">
{{ Form::open(['route'=>'inscrit', 'method'=>'POST']) }}                
                <p class="px-2 flex justify-between py-0 font-bold">Inscription Pédagogique</p>
                <label class="label switch px-2 flex justify-between py-0 mt-2">
                @if($control->inscrit == 0)    
                <input type="checkbox" name="inscrit" value="1">
                <span></span>
                <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                @else
                <input type="checkbox" name="inscrit" checked value="0">
                <span></span>
                <span><button type="submit" class="badge badge_success">Activé</button></span>
                @endif
                </label>
{{ Form::close() }} 
</div>
<hr class="border-dashed mt-5">
<div class="mt-1">
{{ Form::open(['route'=>'reSinscrit', 'method'=>'POST']) }}                
                <p class="px-2 flex justify-between py-0 font-bold">Re-inscription Pédagogique</p>
                <label class="label switch px-2 flex justify-between py-0 mt-2">
                @if($control->reSinscrit == 0)    
                <input type="checkbox" name="reSinscrit" value="1">
                <span></span>
                <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                @else
                <input type="checkbox" name="reSinscrit" checked value="0">
                <span></span>
                <span><button type="submit" class="badge badge_success">Activé</button></span>
                @endif
                </label>
{{ Form::close() }} 
</div>
<hr class="border-dashed mt-5">
<div class="mt-1">
{{ Form::open(['route'=>'openNotePage', 'method'=>'POST']) }}                
                <p class="px-2 flex justify-between py-0 font-bold">La page d'alert pour l'affichage notes</p>
                <label class="label switch px-2 flex justify-between py-0 mt-2">
                @if($control->openNote == 0)    
                <input type="checkbox" name="openNote" value="1">
                <span></span>
                <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                @else
                <input type="checkbox" name="openNote" checked value="0">
                <span></span>
                <span><button type="submit" class="badge badge_success">Activé</button></span>
                @endif
                </label>
{{ Form::close() }} 
</div>
</div>
<br>
<hr class="border-dashed">          
<!-- Sidebar Footer -->
<br><br>
<div class="mt-5">
{{ Form::open(['route'=>'messageClose', 'method'=>'POST']) }}           
         <div class="mb-5 px-4 w-full">
           <label class="label block" for="desc">Message pour maintenance</label>
           <textarea name="closing_msg" class="form-control" rows="4">{{ $control->closing_msg }}</textarea>
 <button type="submit" class="badge badge_primary input-group-item">Mettre à jour</button>           
         </div>
{{ Form::close() }} 
            <hr class="border-dashed">
            <div class="mt-auto flex p-5">
                <button type="button" class="btn btn_danger uppercase" 
                data-toggle="modal"
                data-target="#siteDisabled">
                <span class="las la-exclamation-triangle text-xl"></span>
                Desactiver Application
                </button>
            </div>
        </div>
        </div>
        <!-- Logo -->
        <div id="tab-2" class="collapse p-2">
            <div class="flex items-center py-2 px-2">
                <div class="avatar w-16 h-16 ltr:mr-2 rtl:ml-2">
                    <div class="status bg-success"></div>
                    <?php if (!empty($control->logo)) {
                          echo HTML::image('public/uploads/logo/'.$control->logo.'', '', ['class'=>'']);
                        } else {echo HTML::image('public/assets/images/122.png', '', ['class'=>'']);}
                    ?>
                </div>
                <div>
                    <p>Logo actuel</p>
                </div>
            </div>
    {{ Form::open(['route'=>'applogo', 'files'=>'true']) }}    
            <label class="input-group font-normal py-2 px-2" for="customFile2">
                <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">fichier image</div>
                <input id="customFile2" type="file" name="logo" class="hidden">
                <button type="submit" class="input-group-item badge badge_secondary"><span class="la la-cloud-upload-alt text-xl"></span> Uploader</button> 
           </label>
    {{ Form::close() }}  
<!--Favicon -->      
            <hr class="border-dashed">
            <div class="flex items-center py-2 px-2">
                <div class="avatar w-16 h-16 ltr:mr-2 rtl:ml-2">
                <div class="status bg-success"></div>
                <?php if (!empty($control->favicon)) {
                echo HTML::image('public/uploads/favicon/'.$control->favicon.'', '', ['class'=>'']);
                } else {echo HTML::image('public/assets/images/122.png', '', ['class'=>'']);}
                ?>
            </div>
            <div>
                <p>Favicon actuel</p>
            </div>
            </div>
    {{ Form::open(['route'=>'favicon', 'files'=>'true']) }}    
            <label class="input-group font-normal py-2 px-2" for="customFile3">
                <div class="file-name input-addon input-addon-prepend input-group-item w-full overflow-x-hidden">fichier image</div>
                <input id="customFile3" type="file" name="favicon" class="hidden">
                <button type="submit" class="input-group-item badge badge_secondary"><span class="la la-cloud-upload-alt text-xl"></span> Uploader</button> 
           </label>
    {{ Form::close() }}       
        </div>
    </div>
</div>
</aside>