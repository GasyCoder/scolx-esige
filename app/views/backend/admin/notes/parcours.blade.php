@extends('backend.main')
<?php 
$path = Session::get('language');
$control = Control::find(1); 
?>
@section('title') Ajouter les notes listes des Parcours @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}} de l'étudiant</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/notes/etudiants" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
        @if( count($parcours) > 0)
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                           <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Liste des parcours</th>              
                            @if($control->session_1 == 1)
                            <th class="text-center" style="text-align:center">1er Session</th>
                            @else
                            @endif
                            @if($control->session_2 == 1)    
                            <th class="text-center" style="text-align:center">2ème Session</th>
                            @else
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($parcours as $key=> $parcour)
                        <tr>
                           <td>{{$key+1 }}</td>
                           <td class="font-bold">
                            <a href="{{ URL::current().'/'.$parcour->id}}">{{$parcour->name }}</a> 
                            </td>
                            
                            @if($control->session_1 == 1)  
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{ URL::current().'/'.$parcour->id}}" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Ouvrir
                                </a>
                                </div>
                            </td>
                            @else
                            @endif

                            @if($control->session_2 == 1)    
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{ URL::route('deux_session', [$class->id, $parcour->id])}}" class="badge badge_info" style="color:#fff">
                                    <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Ouvrir
                                </a>
                                </div>
                            </td>
                            @else
                            @endif

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
     @else
     <!-- Layout -->
<div class="alert alert_primary">
    <strong class="uppercase"><bdi>Désolé!</bdi></strong>
     Il n'y a pas des <u><a href="{{URL::route('indexEc')}}" style="color:#EF4444">parcours</a></u> sur ces classe.  
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif
@include('backend.pages.footer')
</main>
  <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tags -->
        <h2 class="p-5">Objets sélectionnés</h2>
        <hr>
         <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Niveau
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
        </div>
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Status -->
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
        <div class="flex gap-2 p-2"> 
         <?php $cours = EC::where('tronc', 1)
                            ->where('class_id', $class->id)
                            ->where('status', 1)->count(); 
        ?>
        @if($cours > 0)  
        <a href="{{ URL::route('commun', $class->id)}}" class="btn btn_danger"><span class="la la-plus text-xl leading-none ltr:mr-1 rtl:ml-1"></span>Ajouter autre notes</a> 
        @endif
        </div>
        </div>
        <hr class="border-dashed mt-5">  
        <!--<div class="p-5 mt-1">
        {{ Form::open(['route'=>'controlSession_1', 'method'=>'POST']) }}                
                        <p class="px-2 flex justify-between py-0 font-bold">Contrôler premier session</p>
                        <label class="label switch px-2 flex justify-between py-0 mt-2">
                        @if($control->session_1 == 0)    
                        <input type="checkbox" name="session_1" value="1">
                        <span></span>
                        <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                        @else
                        <input type="checkbox" name="session_1" checked value="0">
                        <span></span>
                        <span><button type="submit" class="badge badge_success">Activé</button></span>
                        @endif
                        </label>
        {{ Form::close() }} 
        </div>-->
        @if(Auth::user()->is_admin)
        @if(!Auth::user()->is_secretaire)
        <div class="p-5 mt-1">
        {{ Form::open(['route'=>'controlSession_2', 'method'=>'POST']) }}                
                        <p class="px-2 flex justify-between py-0 font-bold">Contrôler la deuxième session</p>
                        <label class="label switch px-2 flex justify-between py-0 mt-2">
                        @if($control->session_2 == 0)    
                        <input type="checkbox" name="session_2" value="1">
                        <span></span>
                        <span><button type="submit" class="badge badge_secondary">Activer</button></span>
                        @else
                        <input type="checkbox" name="session_2" checked value="0">
                        <span></span>
                        <span><button type="submit" class="badge badge_success">Activé</button></span>
                        @endif
                        </label>
        {{ Form::close() }} 
        </div>
        @endif
        @endif
    </aside>
@stop