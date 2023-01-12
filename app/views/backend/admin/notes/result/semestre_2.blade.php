@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
$deliber = Delibera::where('class_id', $class->id)
                        ->where('parcour_id', $parcour->id)
                        ->where('semestre', 2) 
                        ->where('session', 1)
                        ->first();
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">
            <!-- Breadcrumb -->
            <section class="breadcrumb lg:flex items-start">
                <div class="p-8">
                <h3>Résultats Semestre 2</h3>
                <ul>
                    <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Vérification</a></li>
                    <li class="divider la la-arrow-right"></li>
                    <li>2ème Semestre</li>
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
                @if(empty($deliber->deliberation))
                <a href="{{URL::route('deliberation_2', [$class->id, $parcour->id])}}" class="btn btn_success uppercase">
                    <span class="la la-exchange text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                    Activer résultats 
                </a>
                @else
                    @if(Auth::user()->is_admin)
                    @if(!Auth::user()->is_secretaire)
                    <a onclick="return confirm('Vous êtes sur cette action?')" href="{{URL::route('restore_s2', [$class->id, $parcour->id])}}" class="btn btn_danger uppercase">
                        <span class="la la-trash-restore text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                        Restaurer
                    </a>
                    @endif @endif
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
                            @if($class->short == 'L1')
                            <th class="ltr:text-left rtl:text-right" width="80">Moyenne S_2</th>
                            @elseif($class->short == 'L2')
                            <th class="ltr:text-left rtl:text-right" width="80">Moyenne S_4</th>
                            @elseif($class->short == 'L3')
                            <th class="ltr:text-left rtl:text-right" width="80">Moyenne S_6</th>
                            @elseif($class->short == 'M1')
                            <th class="ltr:text-left rtl:text-right" width="80">Moyenne S_8</th>
                            @elseif($class->short == 'M2')
                            <th class="ltr:text-left rtl:text-right" width="80">Moyenne S_10</th>
                            @endif
                            <th class="" width="40">Moyenne Min</th>
                            <th class="" width="40"></th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    @foreach($checks as $key => $check) 
                    <?php      
                            $totalponder        = Credit::where('id_student',       $check->id_student)
                                                        ->where('class_id',         $check->class_id)
                                                        ->where('parcour_id',       $check->parcour_id)
                                                        ->where('yearsUniv',        $check->yearsUniv)
                                                        ->where('semestre', 2)
                                                        ->where('session', 1)
                                                        ->where('status', 1)
                                                        ->sum('Noteponder');                             
                        
                            $summeCoef          = Credit::where('id_student',       $check->id_student)
                                                        ->where('class_id',         $check->class_id)
                                                        ->where('parcour_id',       $check->parcour_id)
                                                        ->where('semestre', 2)
                                                        ->where('session', 1)
                                                        ->where('status', 1)
                                                        ->sum('coef');    

                           $presents           = Credit::where('id_student',       $check->id_student)
                                                        ->where('class_id',         $check->class_id)
                                                        ->where('parcour_id',       $check->parcour_id)
                                                        ->where('status', 1)
                                                        ->where('yearsUniv',        $year->yearsUniv)
                                                        ->where('session', 1)
                                                        ->where('semestre', 1)
                                                        ->count();

                            $genre               = Student::where('id',             $check->id_student)
                                                        ->where('class_id',         $check->class_id)
                                                        ->where('parcour_id',       $check->parcour_id)
                                                        ->first();                             

                    ?>     
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="semi-bold">{{$check->stud->matricule}}</td>
                                <td class="semi-bold">{{$check->stud->fname}} {{$check->stud->lname}}</td>
                                @if($totalponder > 0)
                                <td class="font-bold">
                                    <?php $moyenes_Two =  ($totalponder/$summeCoef); ?>
                                    @if($moyenes_Two >= 10)
                                    <span class="" style="color:green">{{number_format($moyenes_Two, 2, ',', '')}}</span>
                                    @elseif($moyenes_Two >= 9.50 && $moyenes_Two <= 9.99)
                                    <span class="" style="color:blue">{{number_format($moyenes_Two, 2, ',', '')}}</span>
                                    @elseif($moyenes_Two <= 9.49)
                                    <span class="" style="color:red">{{number_format($moyenes_Two, 2, ',', '')}}</span>
                                    @endif
                                </td>
                                @else
                                 <td class="font-bold" style="color:red">
                                    {{number_format($totalponder, 2, ',', '')}}
                                </td>
                                @endif
                                <td class="">10.00</td>
                                   <td class="text-center">
                            @if($presents > 0)         
                                @if(empty($deliber->deliberation))
                                <button href="" class="badge badge_warning" style="color:#fff">
                                    <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    En cours...
                                </button>
                                @else
                                <a href="/admin/detailnotes/semestre_2/niveau/etudiants/{{$check->class_id.'/'.$check->parcour_id.'/'.$check->id_student}}" target="_blank" class="badge badge_primary" style="color:#fff">
                                    <span class="la la-eye text-xl leading-none ltr:mr-2 rtl:ml-2"></span>
                                    Details
                                </a>
                                @endif
                            @else
                            <button href="" class="badge badge_danger" style="color:#fff">
                                    <span class="la la-close text-xl leading-none ltr:mr-0 rtl:ml-0"></span>
                                   @if($genre->sexe == 1) Absent @else Absente @endif
                            </button>
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