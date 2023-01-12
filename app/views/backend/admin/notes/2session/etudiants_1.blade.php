@extends('backend.main')
<?php 
$path = Session::get('language');
$control = Control::find(1); 
?>
@section('title') Ajouter notes 2e session - S_1 @stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div>
            <h3>{{$title}} 1</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Menu</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$sous}} 1</li>
            </ul>
            </div>
        </section>
         <!-- Layout -->
        <div class="flex gap-x-2 mb-5">
            <a href="/admin/notes/2e_session/{{$class->id}}/{{$parcour->id}}" class="btn btn-icon btn-icon_large btn_outlined btn_primary">
                <span class="la la-undo"></span>
            </a>
        </div>
        @include('backend.admin.administration.Pay.return')
        <div class="card p-5">
            <div class="overflow-x-auto">
                <table class="table-sorter table table-auto table_hoverable w-full">
                    <thead>
                        <tr style="color:#000;">
                            <th>#</th>
                            <th class="text-center" style="text-align:center">Photo</th>
                            <th class="text-center" style="text-align:center">Matricule</th> 
                            <th class="ltr:text-left rtl:text-right">Etudiants</th>              
                            @if($control->session_2 == 1)
                            <th class="text-center" style="text-align:center">---</th>
                            @else
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                   @foreach($semestreOne as $key => $deliber) 
                    <?php 
                        $dsexist = Credit::where('session', 2)
                                             ->where('semestre', 1)
                                             ->where('class_id',   $class->id)
                                             ->where('parcour_id', $parcour->id)
                                             ->where('yearsUniv',  $year->yearsUniv)
                                             ->where('id_student', $deliber->id_student)
                                             ->groupBy('id_student')
                                             ->orderBy('id', 'desc')
                                             ->get();
                    ?>
                    @if($deliber->moyenne < 10)
                        <tr>
                           <td>{{$key+1}}</td> 
                           <td class="text-center">
                            <center>
                            <div class="avatar w-4 h-4">
                               @if(!empty($deliber->stud->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$deliber->stud->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                @elseif($deliber->stud->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </div>
                            </center>
                           </td>
                           @if(count($dsexist) > 0)
                           <td class="font-bold text-center" style="color:#16954f">{{$deliber->stud->matricule}}</td>
                           <td class="font-bold">
                            <span style="color:#16954f">{{$deliber->stud->fname.' '.$deliber->stud->lname }}</span> 
                           </td>
                           @else
                           <td class="font-bold text-center" style="color:#6769ad">{{$deliber->stud->matricule}}</td>
                           <td class="font-bold">
                            <span style="color:#6769ad">{{$deliber->stud->fname.' '.$deliber->stud->lname }}</span> 
                           </td>
                           @endif
                           @if(count($dsexist) > 0) 
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <button class="badge badge_success" style="color:#fff" disabled>
                                    <span class="la la-check-circle text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Note ajouté
                                </button>
                                </div>
                            </td>
                            @else
                            @if($control->session_2 == 1)  
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">
                                <a href="{{ URL::route('selectSession1', [$class->id, $parcour->id]).'/'.rtrim(strtr(base64_encode($deliber->id_student), '+/', '-_'), '=')}}" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Voir les matières
                                </a>
                                </div>
                            </td>
                            @endif
                            @endif
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
                Parcours
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ $parcour->abr }}</span>
            </a>
        </div>
        <hr class="border-dashed">
        <div class="flex flex-col gap-y-5 p-5">
            <a href="#" class="flex items-center text-normal">
                <span class="la la-users text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Total étudiants
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{ count($semestreOne) }}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Année Universitaire
                <span class="badge badge_primary ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">{{$year->yearsUniv}}</span>
            </a>
            <a href="#" class="flex items-center text-normal">
                <span class="la la-flag text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Session
                <span class="badge badge_danger ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">2</span>
            </a>
        </div>
    </aside>
@stop