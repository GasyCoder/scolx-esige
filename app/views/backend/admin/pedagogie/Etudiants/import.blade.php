@extends('backend.main')
<?php $path = Session::get('language'); ?>
@section('title') Import étudiants @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
@include('backend.break')
            </div>
        </section>
         <!-- Layout -->
        <div class="card p-4 flex flex-wrap gap-2">
            <a href="{{URL::route('indexEtudiant')}}" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <button class="btn btn_outlined btn_primary">
                    <span class="la la-users"></span>
                    Total: {{count($etudiants)}}
                </button>
                <button class="btn btn_secondary" data-toggle="modal" data-target="#import">
                    <span class="la la-cloud-upload-alt text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Importer fichier
                </button>
                {{ Form::open(['route'=>'data_export', 'files'=>'true' , 'id'=>'myForm', 'data-toggle'=>'validator'])  }}
                <div class="form-group">
                <button type="submit" class="btn btn_info"><span class="la la-cloud-download-alt text-xl leading-none ltr:mr-2 rtl:ml-2"></span> {{ Lang::get($path.'.export_CSV') }}</button>
                </div>
               {{ Form::close() }}
            </div>
        </div>
        <br>
@include('backend.admin.administration.Pay.return')
@if(Session::has('download'))
<div class="alert alert_primary">
    <strong class=""><bdi>Export!</bdi></strong>
    {{ Session::get('success') }}
    <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
    <strong><a href="{{ url() }}/uploads/data/{{ Session::get('download') }}" style="color:#F59E0B">{{ Lang::get($path.'.download') }}</a></strong>
</div><br>
@endif
        <div class="card p-5 mt-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr>
                           <th class="ltr:text-left rtl:text-right">ID</th>
                            <th class="ltr:text-left rtl:text-right">Nom et prénom </th>
                            <th class="ltr:text-left rtl:text-right">Classe </th> 
                            <th class="ltr:text-left rtl:text-right">Parcour </th>                      
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $key=> $student)
                        <tr>
                           <td>{{$key+1}}</td>
                            <td class="font-bold">{{$student->fname}} {{$student->lname}}</td>
                            <td class="font-bold">{{$student->niveau->short}}</td>
                            <td class="font-bold">{{$student->parcour->abr}}</td>
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::route('profileEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}" class="btn btn-icon btn_success">
                                  <span class="la la-user"></span>
                                </a>
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
 <!-- Static Backdrop -->
    <div id="import" class="modal" data-animations="fadeInDown, fadeOutUp" data-static-backdrop>
        <div class="modal-dialog modal-dialog_centered max-w-2xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Import fichier</h3>
                    <button type="button" class="close la la-times" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                <!-- File Browser -->
                <div class="p-5">
                {{ Form::open(['route'=>'importStore', 'files'=>'true', 'class'=>'mt-1', 'id'=>'myForm', 'data-toggle'=>'validator'])  }}
                        <label class="input-group font-normal" for="customFile">
                            {{ Form::file('csv_file', ['class'=>'', 'id'=>'file']) }}
                            <div>
                            @if($errors->first('csv_file'))
                                <span class="help-block text-red-700">{{ $errors->first('csv_file') }}</span>
                              @endif
                           </div>
                            <button type="submit" class="input-group-item btn btn_primary"><span class="la la-upload"></span> Uploader
                            </button>
                        </label>
                {{ Form::close() }}
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@stop