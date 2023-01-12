@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
$verify = Result::where('class_id', $class->id)
                        ->where('parcour_id', $parcour->id)
                        ->where('session', 2)
                        ->count();
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">
            <!-- Breadcrumb -->
            <section class="breadcrumb lg:flex items-start">
                <div class="p-8">
                <h3>Vérification de résultat 2em Session</h3>
                <ul>
                    <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Vérification</a></li>
                    <li class="divider la la-arrow-right"></li>
                    <li>2em Session</li>
                </ul>
                </div>
            </section>
             <!-- Actions -->
            <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
                <a href="/admin/resultats_examen/{{$class->id.'/'.$parcour->id}}" class="btn btn_outlined btn_primary">
                    <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Retour
                </a>
                <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                @if($verify > 0)
                <a href="/admin/resultats_examen/session_2e/officiel/{{$class->id.'/'.$parcour->id}}" class="btn btn_primary uppercase">
                    <span class="la la-file-alt text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Voir résultats 2ème Session
                </a>
                @else
                <a href="{{URL::route('activateS2', [$class->id, $parcour->id])}}" class="btn btn_success uppercase">
                    <span class="la la-exchange text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Activer résultats 
                </a>
                @endif
                </div>
            </div> 
            @include('backend.admin.administration.Pay.return')
            <div class="card p-5 flex flex-col mt-2">
                <table class="table-sorter table w-full mt-3">
                    <thead>
                        <tr>
                            <th class="text-center" width="10">#</th>
                            <th class="ltr:text-left rtl:text-right" width="20">Matricule</th>
                            <th class="ltr:text-left rtl:text-right" width="130">Etudiants</th>
                            <th class="ltr:text-left rtl:text-right" width="80">Moyenne</th>
                            <th class="" width="40">Déliberation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checks as $key => $check) 
                        <?php $moyenne = $check->moyenne; ?>
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="semi-bold">{{$check->stud->matricule}}</td>
                                <td class="semi-bold">{{$check->stud->fname}} {{$check->stud->lname}} </td>
                                <td class="font-bold">
                                    @if($moyenne >= 10)
                                    <span class="" style="color:green">{{number_format($moyenne, 2, ',', '')}}</span>
                                    @elseif($moyenne >= 9.50 && $moyenne <= 9.99)
                                    <span class="" style="color:blue">{{number_format($moyenne, 2, ',', '')}}</span>
                                    @elseif($moyenne <= 9.49)
                                    <span class="" style="color:red">{{number_format($moyenne, 2, ',', '')}}</span>
                                    @endif
                                 </td>
                                <td class="">{{$check->deliberation}}</td>
                            </tr>
                        @endforeach       
                    </tbody>
                </table>
            </div>          
@include('backend.pages.footer')
</main>
@stop