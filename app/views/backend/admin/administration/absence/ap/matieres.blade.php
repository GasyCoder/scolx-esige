@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Gestion d'absence @stop
@section('content')
<!-- Workspace -->
    <main class="workspace workspace_with-sidebar">
@if($class->id == 1)
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
        <!-- Breadcrumb -->
            <h1>Liste des matières </h1>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Pédagogies</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}}</li>
            </ul>
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="{{URL::route('absence')}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>    
 @include('backend.admin.administration.Pay.return')
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                           <th class="ltr:text-left rtl:text-right">#</th>
                            <th class="ltr:text-left rtl:text-right">Liste des matières (EC)</th>                
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($matieres as $element)
                    <?php $show = Absence::where('element_id', $element->id)->first()?>
                        <tr>
                           <td>{{$element->id }}</td>
                           <td class="font-bold">
                            <a href="{{URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=')}}/absence/ap">{{$element->name }}</a> 
                            </td>
                            <td class="text-center">
                                 @if(!empty($show->element_id))
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                 <a href="{{URL::route('listeAp', $class->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '='))}}" class="badge badge_success" style="color:#fff">
                                    <span class="la la-eye  ltr:mr-0 rtl:ml-0"></span>
                                    Ouvrir
                                </a>
                                </div>
                                @endif
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                 <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=') }}/absence/ap" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-plus  ltr:mr-2 rtl:ml-2"></span>
                                    Ajouter
                                </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
                Classe
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
        </div>
    </aside>
@stop