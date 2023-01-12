@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }} @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h1>Résultats de recherche - <code>promotion ({{$instancer->promo}})</code></h1>
            </div>
        </section>
        <div class="breadcrumb breadcrumb_alt p-5 flex flex-wrap gap-2 mt-2">  
            <a href="/admin/tous-etudiants/listes" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
        </div>
        <div class="p-5 border-dashed border" style="border-color:#16A34A;background:#F0F9FF;">  
             {{ Form::open(['route'=>'findStudent', 'method'=>'GET', 'class'=>'flex flex-wrap flex-row -mx-4'])  }}
                <div class="custom-select mt-0 flex-shrink px-4 w-full xl:w-1/2">
                  <select name="student" id="student" class="form-control">
                    @if(!empty($instancer->id))
                    <option value="{{ $instancer->id }}" selected class="font-bold text-primary">{{ $instancer->student->fname }} {{ $instancer->student->lname }}</option>
                    @else
                    <option value="" selected disabled>--Listes des Etudiants par promotion--</option>
                    @endif
                    @foreach($mpianatra as $mpi)
                        <option value="{{ $mpi->id }}">{{ $mpi->fname }} {{ $mpi->lname }}</option>
                    @endforeach
                    </select>
                <div class="custom-select-icon la la-caret-down"></div>
                </div>
                 <div class="custom-select mt-0 flex-shrink px-4 w-full xl:w-1/2">
                  <select name="year" id="year" class="form-control year" style="height:2.9rem">
                    @if(!empty($instancer->promo))
                    <option value="{{ $instancer->promo }}" selected class="font-bold text-primary">{{ $instancer->promo }}</option>
                    @else
                    <option value="" selected disabled>Année de promotion</option>
                    @endif
                    @foreach($taona as $tao)
                        <option value="{{ $tao->yearsUniv }}">{{ $tao->yearsUniv }}</option>
                    @endforeach
                 </select>
                <div class="custom-select-icon la la-caret-down"></div>
                </div>
                <div class="flex flex-wrap gap-2 mt-0 p-5">
                    <button class="btn btn_success"><span class="la la-search text-xl leading-none"></span> Rechercher</button>
                </div>
         {{ Form::close() }} 
         @include('backend.admin.pedagogie.Etudiants.dep')      
        </div> 
@if(count($instances) >= 1)
        <div class="card p-5 mt-5">
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
                        @foreach($instances as $instance)
                        <tr>
                            <td>
                            <div class=" avatar w-5 h-5">
                                @if(!empty($instance->student->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$instance->student->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                @elseif($instance->student->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$instance->student->matricule}}</td>
                            <td class="font-bold">{{$instance->student->fname}} {{$instance->student->lname}}</td>
                            <td class="font-bold">{{$instance->klass}} @if($instance->student->grade == 'AL')<span style="color:#4F46E5">Mixte</span> @endif</td>
                            <td class="font-bold">{{$instance->sokajy}}</td>
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::route('profileEtudiant', [$instance->student->class_id, $instance->student->parcour_id.'/'.rtrim(strtr(base64_encode($instance->id), '+/', '-_'), '=')])}}" class="btn btn-icon btn_success">
                                  <span class="la la-user"></span>
                                </a>    
                                <a href="{{ URL::route('etudiantEdit', [$instance->id, $instance->student->class_id, $instance->student->parcour_id])}}" class="btn btn_outlined btn-icon btn_primary ltr:ml-5 rtl:mr-5"> <span class="la la-pen-fancy"></span>
                                </a>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteStudent', $instance->id)}}" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                                @endif @endif
                                
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
    @stop