@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Bilan des examens</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/resultats_examen_bilan/class/etudiants" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
            <button class="btn btn_outlined btn_success">
                    Année Universitaire: {{$year->yearsUniv}} 
            </button>    
            </div>
        </div> 
      
@include('backend.admin.administration.Pay.return')
            <div class="card p-5 flex flex-col mt-5">
                <h3>Statistique des Admis</h3>
                <div class="flex flex-col ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto badge badge_danger font-bold">Total Non admis: {{count($bilanNonAdmis)}}</div>
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Classes</th>
                            <th class="" align="center">Non Admis</th>
                            <th class="" align="center">Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <?php
                            $Etudiants = Student::where('class_id', $class->id)
                                                  ->where('yearsUniv', $year->yearsUniv)
                                                  ->count();

                            $Nonadmis = Bilan::where('class_id', $class->id)
                                            ->where('admis', 0)
                                            ->where('moyenne', '<=', 9.99)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count();

                            //$percent = $Lesadmis*100/$Etudiants;
                        ?>
                        <tr>
                            <td>{{$class->name}}</td>
                            <td class="" align="center">
                                @if($Nonadmis > 0)
                                <div class="badge badge_danger">{{$Nonadmis}}</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0</div>
                                @endif
                            </td>
                            <td class="" align="center">
                                @if($Nonadmis > 0)
                                <div class="badge badge_danger">{{number_format($Nonadmis*100/$Etudiants, 1, ',', '')}}%</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0%</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 

@include('backend.pages.footer')
</main>
@stop