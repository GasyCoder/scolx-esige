@extends('backend.main')
<?php 
$path = Session::get('language'); 
$control = Control::find(1); 
?>
@if(Auth::user()->is_admin)
  @section('title') {{$control->school_name}} @stop
@endif
@if(Auth::user()->is_student)
  @section('title') {{ Lang::get($path.'.Control_Panel') . ' - ' . Lang::get($path.'.student') }} @stop
@endif
@if(Auth::user()->is_teacher)
  @section('title') {{ Lang::get($path.'.Control_Panel') . ' - ' . Lang::get($path.'.teacher') }} @stop
@endif  
@if(Auth::user()->is_secretaire)
  @section('title')  Compte Sécretaire @stop
@endif
@section('content')
@include('backend.timeAgo')
       <!-- Workspace -->
<main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb">
        <!-- Breadcrumb -->
            <h1>{{$title}}</h1>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Année d'étude</a></li>
                <li class="divider la la-arrow-right"></li>
                <li class="font-bold">{{$years->yearsUniv}}</li>
            </ul>
        </section>
        <div class="grid lg:grid-cols-2 gap-5">
@include('backend.admin.count')
            <div class="grid lg:grid-cols-1 gap-5">   
@include('backend.pages.alerts')                 
            <!-- Categories -->
                <div class="card p-5">
                    <h3 class="underline"><i class="la la-sticky-note"></i> Bloc note</h3>
                    <div class="mt-2 leading-normal">
                        @foreach($notes as $note)  
                    <div class="ltr:mr-5 rtl:ml-5">
                        <h5 class="text-sm"><i class="la la-user"></i> {{$note->user->fname}}
                            <sup class="badge badge_outlined {{$note->typeclass}}" style="float:right;">{{ $note->typepriority }} </sup>
                        </h5>
                        <p class="">{{ $note->textnote }} 
                            @if (!Auth::user()->is_secretaire OR $note->user->id == Auth::user()->id)
                            <sup><a onclick="return confirm('{{ Lang::get($path.'.delete') }}')" href="{{ URL::route('admin_notes_destroy', $note->id) }}" style="color:red" class="text-xl">
                            <span class="la la-trash-alt" style="color:red;float:right;"></span> 
                            </a>
                          </sup>
                          @endif
                        </p>
                        </div> 
                        <hr class="my-2"> 
                        @endforeach
                    </div>
            @include('backend.admin.dashboard.addNote')
            </div>
            </div>
            @if($payed > 0)
            <div class="card p-5 flex flex-col mt-5">
                @include('backend.admin.bar')
            </div>
            @include('backend.admin.recente')
            @endif
            <!-- Recent Statistique -->
            <div class="card p-5 flex flex-col mt-5">
                <h3>Effectif étudiants par niveau</h3>
                <button class="ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto badge badge_success">
                <?php $students = Student::where('yearsUniv', $years->yearsUniv)->count();?>    
                Total: {{$students}}</button>
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Niveau</th>
                            <th class="" align="center">Total étudiants</th>
                            <th class="" align="center">Auditeur Libre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classe as $st)
                        <?php 
                            $student = Student::where('class_id', $st->id)
                                                  ->where('yearsUniv', $years->yearsUniv)
                                                  ->where('grade', NULL)
                                                  ->count();

                           $mixte   = Student::where('class_id', $st->id)
                                                  ->where('yearsUniv', $years->yearsUniv)
                                                  ->where('grade', '=', 'AL')
                                                  ->count();                       
                        ?>
                        <tr>
                            <td>{{$st->name}}</td>
                            <td class="" align="center">
                                @if($student > 0)
                                <div class="badge badge_success">{{$student}}</div>
                                @else
                                 <span class="badge badge_outlined badge_secondary"> 0 </span>
                                @endif
                            </td>
                            <td align="center">
                                 @if($mixte > 0)
                                    <div class="badge badge_primary">{{$mixte}}</div>
                                 @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
            <div class="card p-5 flex flex-col mt-5">
                <h3>Statistique Absence</h3>
                <?php 
                    $absence = Absence::where('status', 0)
                                        ->where('yearsUniv', $years->yearsUniv)
                                        ->count();
                    $presence = Absence::where('status', 1)
                                        ->where('yearsUniv', $years->yearsUniv)
                                        ->count();                  
                ?>
                <div class="flex flex-col ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto badge badge_success">Total présence: {{$presence}}</div>
                <div class="ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto badge badge_danger">Total absence: {{$absence}}</div>
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Niveau</th>
                            <th class="" align="center">Total présent</th>
                            <th class="" align="center">Total absent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classe as $st)
                        <?php 
                            $absent = Absence::where('status', 0)
                                                ->where('class_id', $st->id)
                                                ->where('yearsUniv', $years->yearsUniv)
                                                ->count();
                            $present = Absence::where('status', 1)
                                                ->where('class_id', $st->id)
                                                ->where('yearsUniv', $years->yearsUniv)
                                                ->count();
                        ?>
                        <tr>
                            <td>{{$st->name}}</td>
                            <td class="" align="center">
                                @if($present > 0)
                                <div class="badge badge_success">{{$present}}</div>
                                @else
                                 <span class="badge badge_outlined badge_secondary"> 0 </span>
                                @endif
                            </td>
                            <td class="" align="center">
                                @if($absent > 0)
                                <div class="badge badge_danger">{{$absent}}</div>
                                @else
                                <span class="badge badge_outlined badge_secondary"> 0 </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>
        <div class="grid lg:grid-cols-2 gap-5"> 
        <div class="card p-5 flex flex-col mt-5">
                <h3>Taux de paiement</h3>
                <?php 
                    $x =  DB::table('students')
                                ->where('yearsUniv', $years->yearsUniv)
                                ->count();

                    $y  = DB::table('payments')
                                ->where('nbreMois', '>=', '1')
                                ->where('yearsUniv', $years->yearsUniv)
                                ->count();
                ?>
                @if($y > 0)
                <button class="ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto badge badge_success">Total: 
                {{number_format($y*100/$x, 1, ',', '')}}%
                </button> @endif
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Niveaux</th>
                            <th class="" align="center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classe as $st)
                        <?php 
                            $alls =  DB::table('students')
                                        ->where('class_id', $st->id)
                                        ->where('yearsUniv', $years->yearsUniv)
                                        ->count();

                            $pay  = DB::table('payments')
                                        ->where('class_id', $st->id)
                                        ->where('nbreMois', '>=', '1')
                                        ->where('yearsUniv', $years->yearsUniv)
                                        ->count();
                        ?>
                        <tr>
                            <td>{{$st->name}}</td>
                            <td class="" align="center">
                                @if($pay > 0)
                                <div class="badge badge_success">
                                {{number_format($pay*100/$alls, 1, ',', '')}}%</div>
                                @else
                                 <span class="badge badge_outlined badge_secondary"> 0%</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>     
@include('backend.pages.footer')
</main>
@stop