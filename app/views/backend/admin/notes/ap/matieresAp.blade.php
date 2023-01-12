@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Liste des matières - {{$class->name}} @stop
@section('content')
<!-- Workspace -->
    <main class="workspace workspace_with-sidebar">
@if($class->id == 1)
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>Ajouter notes par matières - {{$class->short}} - année d'étude {{$years->yearsUniv}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Notes</a></li>
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
        @include('backend.admin.administration.Pay.return')
        @if( count($cours) > 0)
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                           <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Liste des matières (EC)</th>  
                            <th class="text-center" style="text-align:center">Note ajouté</th>              
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cours as $key=> $matap)
                    <?php $checkNote = Note::where('element_id', $matap->id)
                                            ->where('class_id', $matap->class_id)
                                            ->where('parcour_id', $matap->parcour_id)
                                            ->where('yearsUniv', $years->yearsUniv)
                                            ->first() ?>
                        <tr>
                           <td>{{$key+1}}</td>
                            @if (!empty($checkNote))
                            <td class="">
                            <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($matap->id), '+/', '-_'), '=').'/'.$matap->codeEc}}/afficher/notes">{{$matap->name }}</a> 
                            </td>
                            @else
                            <td class="font-bold">
                            <a href="{{URL::current().'/'.rtrim(strtr(base64_encode($matap->id), '+/', '-_'), '=').'/'.$matap->codeEc}}/noteAp/ajouter">{{$matap->name }}</a> 
                            </td>
                            @endif
                            
                            @if (!empty($checkNote))
                            <td class="text-center"><span class="badge badge_outlined badge_success font-bold">Oui</span></td>
                            @else
                            <td class="text-center"><span class="badge badge_outlined badge_danger font-bold">Non</span></td>
                            @endif
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                @if (!empty($checkNote))    
                                <a href="{{ URL::current().'/'.$matap->parcour_id.'/'.rtrim(strtr(base64_encode($matap->id), '+/', '-_'), '=').'/'.$matap->codeEc}}/afficher/notes_ap" class="badge badge_success" style="color:#fff">    
                                    <span class="la la-eye  ltr:mr-1 rtl:ml-1"></span>
                                    Afficher
                                </a>
                                @else
                                <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($matap->id), '+/', '-_'), '=').'/'.$matap->codeEc}}/noteAp/ajouter" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-plus  ltr:mr-1 rtl:ml-1"></span>
                                    Ajouter
                                </a>
                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
    <div class="alert alert_primary">
    <strong class="uppercase"><bdi>Désolé!</bdi></strong>
     Il n'y a pas des <u><a href="{{URL::route('indexEc')}}" style="color:#EF4444">éléménts constitutifs</a></u> sur ces classe et parcour.  
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
    @endif
@endif
@include('backend.pages.footer')
</main>
@stop