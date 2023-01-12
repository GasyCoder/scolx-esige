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
@include('backend.break')
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2 mt-2">  
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <a href="{{ URL::route('add_enseignant')}}" class="btn btn_success">
                    <span class="la la-plus-circle text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Ajouter enseignant
                </a>
            </div>
        </div>       
@if(count($teachers) >= 1)
        <div class="card p-5 mt-2">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Photo</th>
                            <th class="ltr:text-left rtl:text-right">Nom complet</th>
                            <th class="ltr:text-left rtl:text-right">Grade </th>                   
                            <th class="text-center" style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                        <tr>
                            <td>
                            <div class=" avatar w-5 h-5">
                                @if(!empty($teacher->image))
                                <?php echo HTML::image('uploads/profiles/teachers/'.$teacher->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                @elseif($teacher->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </td>
                            <td class="font-bold">{{$teacher->fname}} {{$teacher->lname}}</td>
                            <td class="font-bold">
                                @if($teacher->grade == 'Mme.') Madame @elseif($teacher->grade == 'Dr.') Docteur @elseif($teacher->grade == 'Mr.') Monsieur @elseif ($teacher->grade == 'Pr.') Proffeseur @else @endif
                            </td>
                             <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{URL::current().'/'.rtrim(strtr(base64_encode($teacher->id), '+/', '-_'), '=')}}" class="btn btn-icon btn_success">
                                  <span class="la la-user"></span>
                                </a>
                                <a href="{{ URL::route('TeacherEdit', $teacher->id)}}" class="btn btn-icon btn_primary ltr:ml-5 rtl:mr-5"> <span class="la la-pen-fancy"></span></a>
                                @if(Auth::user()->is_admin) @if(!Auth::user()->is_secretaire)
                                <a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('deleteteacher', $teacher->id)}}" class="btn btn-icon btn_danger ltr:ml-2 rtl:mr-2">
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
 Il n'y a pas des données disponible ici. Veuillez ajouter votre <b><a href="{{ URL::route('add_enseignant')}}" class="underline">enseignants</a></b>.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif     
@include('backend.pages.footer')
</main>
@stop