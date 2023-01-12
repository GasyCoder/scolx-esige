@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Ajouter les notes - Tronc commun @stop
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
         <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/notes/etudiants/{{$class->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
           <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <span class="badge badge_outlined badge_success font-bold">
                    <span class="la la-flag text-xl leading-none"></span>
                    Année Universitaire: {{$year->yearsUniv}} 
                </span>
            </div> 
        </div> 
        @if( count($tambatra) > 0)
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                            <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Liste des matières tronc commun</th>
                            <th class="text-center" style="text-align:center">Note ajouté</th>  
                            <th class="text-center" style="text-align:center">Actions</th>
                            <!--<th class="" style="text-align:center">Tronc commun</th>-->
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tambatra as $key=> $element)
                    <?php $checkNote = Note::where('codeEc', $element->codeEc)
                                            ->where('class_id', $element->class_id)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->first() ?>    
                        <tr>
                           <td>{{$key+1 }}</td>
                           @if (!empty($checkNote))
                           <td class="">
                            <a href="">{{$element->name }}</a> 
                            </td>
                            @else
                           <td class="font-bold">
                            <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/notes_tronc/add">{{$element->name }}</a> 
                            </td>
                            @endif
                            @if (!empty($checkNote))
                            <td class="text-center"><span class="badge badge_success font-bold">Oui</span></td>
                            @else
                            <td class="text-center"><span class="badge badge_danger font-bold">Non</span></td>
                            @endif
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                @if (!empty($checkNote))    
                                <a href="{{ URL::route('displayAll', $class->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc)}}" class="badge badge_success" style="color:#fff">
                                    <span class="la la-eye  ltr:mr-1 rtl:ml-1"></span>
                                    Afficher
                                </a>
                                @else
                                <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.$element->codeEc}}/notes_tronc/add" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-plus  ltr:mr-1 rtl:ml-1"></span>
                                    Ajouter
                                </a>
                                @endif
                                </div>
                            </td>
                            <!--<td class="text-center">
                            <span class="badge badge_success"><span class="la la-check"></span> 
                            </span>
                            </td>-->
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
@stop