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
            <h3>Relevé des notes pour - {{$class->name}}</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Relevés</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/releve_notes/class/etudiants" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto"> 
                <button class="btn btn_outlined btn_success">
                    <span class="la la-flag text-xl leading-none"></span> Année Universitaire: {{$year->yearsUniv}}
                </button>    
            </div>
        </div>       
@if($theNote > 0)
        <div class="card p-5 mt-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Photo</th>
                            <th class="ltr:text-left rtl:text-right">Matricule</th>
                            <th class="ltr:text-left rtl:text-right">Nom complet</th>
                            <th class="ltr:text-left rtl:text-right">Classe</th>       
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentsAp as $student)
                        <?php 
                            $haveNote = Note::where('id_student', $student->id)
                                            ->where('class_id', $class->id)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count();

                            $libreNote   = Note::where('id_student', $student->id)
                                            ->where('class_id', $student->class_id)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->first();                
                        ?>
                        @if($haveNote > 0)
                        <tr>
                            <td>
                            <div class=" avatar w-5 h-5">
                                @if(!empty($student->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                @elseif($student->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$student->matricule}}</td>
                            <td class="font-bold">{{$student->fname}} {{$student->lname}}</td>
                            <td class="font-bold">{{$student->niveau->short}} @if($student->grade == 'AL')<span style="color:#4F46E5">Mixte</span> @endif</td>
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::current().'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')}}" target="_blank" class="btn btn-icon btn_success">
                                  <span class="la la-file text-xl"></span>
                                </a>
                                <a href="#" class="btn btn_outlined btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                    @foreach($mixtes as $mix)
                        <?php 
                            $myNote      = Note::where('id_student', $mix->id)
                                            ->where('class_id', $mix->class_id)
                                            ->count();

                            $auditeur   = Note::where('id_student', $mix->id)
                                            ->where('class_id', $mix->class_id)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->first();                
                        ?>
                        @if($myNote > 0)
                        <tr>
                            <td>
                            <div class=" avatar w-5 h-5">
                                @if(!empty($mix->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$mix->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                @elseif($mix->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$mix->matricule}}</td>
                            <td class="font-bold">{{$mix->fname}} {{$mix->lname}}</td>
                            <td class="font-bold">@if($auditeur->grade == 'AL')<span >Auditeur Libre</span> @endif</td>
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::current().'/'.rtrim(strtr(base64_encode($mix->id), '+/', '-_'), '=')}}" target="_blank" class="btn btn-icon btn_success">
                                  <span class="la la-file text-xl"></span>
                                </a>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)    
                                <a href="#" class="btn btn_outlined btn-icon btn_danger ltr:ml-2 rtl:mr-2">
                                 <span class="la la-trash-alt"></span>
                                </a>
                                @endif @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                       @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
@else
<br>
<div class="alert alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Il n'y a pas des données disponible ici. Veuillez ajouter votre <b><a href="" class="underline">notes</a></b>.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif     
@include('backend.pages.footer')
</main>
@stop