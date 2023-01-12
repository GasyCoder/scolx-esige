@extends('backend.main')
<?php 
$path = Session::get('language');
$control = Control::find(1); 
?>
@section('title') Notes Examens - {{$class->name}} @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/notes/etudiants/{{$class->id}}/{{$parcour->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
        @include('backend.admin.administration.Pay.return')
        @if( count($matieres) > 0)
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                           <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Liste des matières (EC)</th>
                            <th class="text-center" style="text-align:center">Semestre</th>              
                            @if($control->session_1 == 1)
                            <th class="text-center" style="text-align:center">Note</th>
                            @else
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($matieres as $key=> $element)
                    <?php 
                             $checkNote1 = Note::where('element_id',   $element->id)
                                                 ->where('codeUe',     $element->codeUe)
                                                 ->where('class_id',   $element->class_id)
                                                 ->where('parcour_id', $element->parcour_id)
                                                 ->where('yearsUniv',  $year->yearsUniv)
                                                 ->where('status', 1)
                                                 ->first(); 
                    ?>
                        <tr>
                           <td>{{$key+1 }}</td>
                           @if (!empty($checkNote1))
                            <td class="">
                            <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/afficher/notes">{{$element->name }}</a> 
                            </td>
                           @else
                           <td class="font-bold">
                            <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/notes/add">{{$element->name }}</a> 
                           </td>
                           @endif
                           <td class="text-center"><span class="badge badge_outlined badge_primary"><b>{{$element->semestre}}</b></span></td> 
                            @if($control->session_1 == 1)  
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                @if (!empty($checkNote1))    
                                <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/afficher/notes/examen" class="badge badge_success" style="color:#fff">
                                    <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Afficher
                                </a>
                                @else
                                <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/notes/ajouter" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-plus text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Ajouter note
                                </a>
                                @endif 
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
         Il n'y a pas des <u><a href="{{URL::route('indexEc')}}" style="color:#EF4444">éléménts constitutifs</a></u> sur ces classe et parcour.  
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
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
             <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Parcours
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->abr }}</span>
            </a>
        </div>
        <hr class="border-dashed">
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Année Universitaire
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$year->yearsUniv}}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Session
                <span class="badge badge_outlined badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">1<sup>ère</sup></span>
            </a>
        </div>
        @if (!empty($checkNote1))  
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Status -->
        <hr>
        <div class="flex flex-col gap-y-5 p-5">
        <div class="flex gap-2 p-2"> 
         @if(Session::has('download'))
         <a href="{{ url() }}/uploads/notes/{{ Session::get('download') }}" class="btn btn_success"><span class="la la-cloud-download-alt text-xl leading-none ltr:mr-1 rtl:ml-1"></span>Télécharger</a> 
        @endif
        {{ Form::open(['route'=>'exportNote', 'files'=>'true' , 'id'=>'myForm', 'data-toggle'=>'validator'])  }}
        <button type="submit" class="btn btn_primary"><span class="la la-file-alt text-xl leading-none ltr:mr-1 rtl:ml-1"></span>Exporter</button> 
        {{ Form::close() }}
        </div>
        </div>
        @endif
    </aside>
@stop