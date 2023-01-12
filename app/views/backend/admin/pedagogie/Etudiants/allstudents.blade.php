@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title. ' '.$year->yearsUniv}} @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>List des étudiants</h3>
            </div>
        </section>
         <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/etudiants/inscription" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto"> 
                @if(Session::has('download'))
                <a href="{{ url() }}/uploads/data/{{ Session::get('download') }}" class="btn btn_warning" style="color:#333">
                    <span class="la la-cloud-download-alt text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Télécharger .csv
                </a>
                @endif
                 <a class="btn btn_danger" href="{{ URL::route('filterOne')}}">
                    <span class="la la-filter text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Filtrer
                </a>
                <button class="btn btn_success" data-toggle="modal" data-target="#import">
                    <span class="la la-cloud-upload-alt text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Importer
                </button>
                {{ Form::open(['route'=>'data_export', 'files'=>'true' , 'id'=>'myForm', 'data-toggle'=>'validator'])  }}
                <div class="form-group">
                <button type="submit" class="btn btn_info">
                    <span class="la la-file-alt text-xl leading-none ltr:mr-1 rtl:ml-1"></span> Exporter
                </button>
                </div>
               {{ Form::close() }}
                <button class="btn btn_secondary">
                    Total: {{count($students)}}
                </button>      
            </div>
        </div> 
        <div class="p-5 border-dashed border" style="border-color:#16A34A;background:#F0F9FF;">  
             {{ Form::open(['route'=>'findStudent', 'method'=>'GET', 'class'=>'flex flex-wrap flex-row -mx-4'])  }}
                <div class="custom-select mt-0 flex-shrink px-4 w-full xl:w-1/2">
                    <select name="student" id="student" class="form-control">
                        <option value="" selected disabled>--Listes des Etudiants par promotion--</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->fname }} {{ $student->lname }}</option>
                            @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
                </div>
                 <div class="custom-select mt-0 flex-shrink px-4 w-full xl:w-1/2">
                  <select name="promo" id="promo" class="form-control promo" style="height:2.8rem">
                    <option value="" selected disabled>Année de promotion</option>
                    @foreach($promos as $prom)
                        <option value="{{ $prom->year }}">{{ $prom->year }}</option>
                    @endforeach
                 </select>
                <div class="custom-select-icon la la-caret-down"></div>
                </div>
                <div class="flex flex-wrap gap-2 mt-5 p-5">
                    <button class="btn btn_success"><span class="la la-search text-xl leading-none"></span> Rechercher</button>
                </div>
         {{ Form::close() }} 
         @include('backend.admin.pedagogie.Etudiants.dep')      
        </div> 
@if(count($students) >= 1)
        <div class="card p-5 mt-2">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Photo</th>
                            <th class="ltr:text-left rtl:text-right">Matricule</th>
                            <th class="ltr:text-left rtl:text-right">Nom complet</th>
                            <th class="ltr:text-left rtl:text-right">Niveau </th> 
                            <th class="ltr:text-left rtl:text-right">Parcours </th>              
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <?php 
                            $instance = Instance::where('id',$student->id)->first();
                            $fichier  = Fichier::where('id', $student->id)->first();                      
                        ?>
                        <tr>
                            <td>
                                <div class="w-5 h-5">
                                    @if(!empty($fichier->image))
                                    <?php echo HTML::image('uploads/profiles/students/'.$fichier->image.'', '', ['class'=>'', 'width'=>'','class'=>'avatar', 'style'=>'border: 2px dotted green']) ?>
                                    @elseif($instance->sexe == 1)
                                    {{ HTML::image('public/assets/avatar/0.jpg', '', ['class'=>'avatar', 'width'=>'','height'=>'']) }}
                                     @else {{ HTML::image('public/assets/avatar/2.png', '', ['class'=>'avatar', 'width'=>'','height'=>'']) }}
                                    @endif
                                </div>
                            </td>
                            <td class="font-bold">{{$student->matricule}}</td>
                            <td class="font-bold">{{$student->fname}} {{$student->lname}}</td>
                            @if($student->class_id > 0)
                            <td class="font-bold">
                            {{$student->niveau->short}} 
                            @endif 
                            @if($student->grade == 'AL')
                                    <span style="color:#4F46E5">Mixte</span> 
                            @endif
                            </td>
                            @if($student->class_id >= 2)
                            <td class="font-bold">{{$student->parcour->abr}}</td>
                            @else <td class="">---</td> @endif
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::route('profileEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}" class="btn btn-icon btn_success">
                                  <span class="la la-user"></span>
                                </a>    
                                <a href="{{ URL::route('etudiantEdit', [$student->id, $student->class_id, $student->parcour_id])}}" class="btn btn_outlined btn-icon btn_primary ltr:ml-2 rtl:mr-2"> <span class="la la-pen-fancy"></span></a>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteStudent', $student->id)}}" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
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
@else
<br>
<div class="alert alert_outlined alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Il n'y a pas des données disponible ici. Veuillez ajouter votre <b><a href="{{ URL::route('inscriptions')}}" class="underline">étudiants</a></b>.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif
@section('js')
<script type="text/javascript">
 $('#student').select2();
</script>
<script type="text/javascript">
 $('#year2').select2();
</script>
@endsection     
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