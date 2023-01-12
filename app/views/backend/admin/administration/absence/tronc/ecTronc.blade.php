@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Gestion d'absence @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>

         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/absences/etudiants/{{$class->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
        @if( count($ecTronc) > 0)
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
                    @foreach($ecTronc as $key=> $element)
                    <?php $show = Absence::where('element_id', $element->id)->first()?>
                        <tr>
                           <td>{{$key+1 }}</td>
                           <td class="font-bold">
                            <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($element->codeEc), '+/', '-_'), '=') }}/absence_tronc/add">{{$element->name }}</a> 
                            </td>
                            <td class="text-center">
                                @if(!empty($show->element_id))
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                 <a href="{{URL::route('alltronc', $class->id.'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '='))}}" class="badge badge_success" style="color:#fff">
                                    <span class="la la-eye  ltr:mr-0 rtl:ml-0"></span>
                                    Ouvrir
                                </a>
                                </div>
                                @endif
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                 <a href="{{ URL::current().'/'.rtrim(strtr(base64_encode($element->id), '+/', '-_'), '=').'/'.rtrim(strtr(base64_encode($element->codeEc), '+/', '-_'), '=') }}/absence_tronc/add" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-plus  ltr:mr-0 rtl:ml-0"></span>
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
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $class->short }}</span>
            </a>
             <a href="#" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Tronc commun
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">Oui</span>
            </a>
        </div>
    </aside>
@stop