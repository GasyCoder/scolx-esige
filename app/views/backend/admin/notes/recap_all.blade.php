@extends('backend.main')
<?php 
$path = Session::get('language');
$control = Control::find(1); 
?>
@section('title') Récapitulatif notes des étudiants @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}} - {{$class->short}}</h3>
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
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table_bordered w-full">
                    <thead>
                        <tr style="color:#000;">
                           <th class="text-center" style="text-align:center" width="150">N° Matricule</th>
                            <th class="ltr:text-left rtl:text-right">Etudiant</th>              
                            <th class="text-center" style="text-align:center">Matières</th>  
                            <th class="text-center" style="text-align:center">Note/20</th>
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($recapNotes as $key=> $recap)
                   
                        <tr>
                           <td style="text-align:center">{{$recap->stud->matricule }}</td>
                            <td class="">
                            <a href="">{{$recap->stud->fname.' '.$recap->stud->lname }}</a> 
                            </td>
                           <td style="text-align:center">{{$recap->mat->name. ' ('.$recap->mat->abr. ')'}}</td> 
                           
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="" class="badge badge_success" style="color:#fff">
                                    {{$recap->note}}
                                </a>
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    
                                    <a href="" class="btn btn-icon btn_primary ltr:ml-2 rtl:mr-2 font-bold">
                                        <span class="la la-file-alt text-xl"></span>
                                    </a>
                                    <a href="" class="btn btn-icon btn_success ltr:ml-2 rtl:mr-2">
                                        <span class="la la-pen-fancy"></span>
                                    </a>
                                    @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                    <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('remove_ec', 1) }}" class="btn btn-icon  btn_danger ltr:ml-2 rtl:mr-2">
                                        <span class="la la-trash-alt"></span>
                                    </a>
                                    @endif
                                    @endif
                                </div>
                                </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@include('backend.pages.footer')
</main>
@stop