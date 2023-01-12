@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }} @stop
@section('content')
    <main class="workspace">
@if(count($students)>0)        
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h1>Résultats de recherche étudiant(s) </h1>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/reinscription/esige/etudiant" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
        </div>
        <div class="container flex items-center justify-center">
        <div class="w-full md:w-1/2 xl:w-1/3"> 
        <div class="badge badge_success">
         Vous avez trouvé {{count($students)}} résulat(s) de votre recherche (<u>{{ Input::get('q') }}</u>)...  
        </div>
        </div>
        </div>
            <div class="card p-5 mt-3">
            <div class="overflow-x-auto"> 
               <table class="table-sorter table table_striped w-full">
                    <thead>
                        <tr>
                            <th class="" width="50">Photo</th>
                            <th class="ltr:text-left rtl:text-right" width="10">Matricule</th>
                            <th class="ltr:text-left rtl:text-right" width="350">Nom complet</th>
                            <th class="text-center" style="text-align:center" width="110">Vérification</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                    <?php 
                    $thisNote = Note::where('id_student', $student->id)
                                      ->groupBy('id_student')
                                      ->first(); 
                    ?>
                        <tr>
                            <td class="text-center">
                            <center class="avatar w-5 h-5">
                                @if(!empty($student->image))
                                <?php echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'text-center', 'width'=>'','height'=>'']) ?>
                                @elseif($student->sexe == 1)
                                {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                 @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                @endif
                            </center>
                            </td>
                            <td class="font-bold">{{$student->matricule}}</td>
                            <td class="font-bold">{{$student->fname}} {{$student->lname}}</td>
                            <td class="text-center">
                                <div class="inline-flex ltr:ml-auto rtl:mr-auto">  
                                    <a href="{{URL::route('checkEtudiant', [$student->class_id, $student->parcour_id.'/'.rtrim(strtr(base64_encode($student->id), '+/', '-_'), '=')])}}" class="badge badge_success" style="color:#fff">
                                        <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                        Vérifier
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
        <br><br>
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/reinscription/esige/etudiant" class="btn btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
        </div> 
        <div class="alert alert_outlined alert_danger">
        <strong class="uppercase"><bdi>Désolé!</bdi></strong>
         Aucun résultat de votre recherche (<u>{{ Input::get('q') }}</u>)...  
        <button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
        </div>
        @endif
@include('backend.pages.footer')
</main>
@stop