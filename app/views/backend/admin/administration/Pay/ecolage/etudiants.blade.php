@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') Paiement-{{ $title }} @stop

@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
@include('backend.break')
            </div>
        </section>
         <!-- Actions -->
        <div class="card p-3 flex flex-wrap gap-2">
            @if($class->id >= 2)
            <a href="/admin/paiement/ecolage/{{$class->id}}" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @else
            <a href="/admin/paiement/ecolage" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            @endif
            @if($class->id >= 2)
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
                <button class="btn btn_outlined btn_success text-gray-700">
                    <span class="la la-folder text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                    Parcour: {{$parcour->name}}
                </button>
            </div>
            @endif
        </div>       
@if(count($etudiants) >= 1)
   <div class="p-8 mt-5">
            <div class="overflow-x-auto">
<!-- Bordered -->
                <div class="card p-5">
                    <table class="table-sorter table_hoverable table w-full mt-3">
                        <thead>
                            <tr>
                                <th class="text-center" style="text-align:center;">Photo</th>
                                <th class="ltr:text-left rtl:text-right">Nom complet</th>
                                <th class="ltr:text-left rtl:text-right">Matricule</th>
                                <th class="ltr:text-left rtl:text-right">Niveau</th>
                                <th class="text-center" style="text-align:center;">%</th>
                                <th class="text-center" style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                @foreach($etudiants as $etudiant)     
                            <tr>
                                <td class="flex justify-center"> 
                                    <a href="{{ URL::route('checkPay', $etudiant->id) }}"> 
                                    <div class="avatar w-7 h-5">
                                       @if(!empty($etudiant->image))
                                        <?php echo HTML::image('uploads/profiles/students/'.$etudiant->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) ?>
                                        @elseif($etudiant->sexe == 1)
                                        {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                         @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                                        @endif
                                    </div>
                                    </a>
                                </td>
                                <td class="">
                                    <a href="{{ URL::route('checkPay', $etudiant->id) }}"> 
                                    {{$etudiant->fname}} {{$etudiant->lname}}
                                    </a>
                                </td>
                                <td class="">{{$etudiant->matricule}}</td>
                                <td class="">{{$etudiant->niveau->short}} 
                                    @if($etudiant->grade == 'AL')Auditeur Libre @endif
                                </td>
                                <td style="text-align:center;">
                                <?php 
                                    $nbreMois = Pay::where('class_id',     $class->id)
                                                    ->where('id_etudiant', $etudiant->id)
                                                    ->where('parcour_id',  $parcour->id)
                                                    ->where('yearsUniv',   $year->yearsUniv)
                                                    ->sum('nbreMois');
                                   $taux      = $nbreMois*100/10; 
                                   //10 => 100%  
                                   //2 => ?
                                   $payed      = Pay::where('class_id',    $class->id)
                                                    ->where('id_etudiant', $etudiant->id)
                                                    ->where('parcour_id',  $parcour->id)
                                                    ->where('yearsUniv',   $year->yearsUniv)
                                                    ->where('nbreMois', '>=', 1)
                                                    ->count();         
                                ?>

                                @if($payed > 0)
                                <span class="badge badge_success">{{number_format($taux, 1, ',', '')}}%</span>
                                @else
                                <span class="badge badge_outlined badge_secondary">0%</span>
                                @endif
                                </td>
                                <td class="text-center">
                                    <div class="inline-flex ltr:ml-auto rtl:mr-auto">   
                                        <a href="{{ URL::route('checkPay', $etudiant->id) }}" class="badge badge_primary" style="color:#fff"><span class="la la-money-check text-xl leading-none ltr:mr-2 rtl:ml-2"></span>Payer</a>    
                                    </div>
                                </td>
                            </tr>
                        @endforeach             
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@else
<br>
<div class="alert alert_outlined alert_danger">
<strong class="uppercase"><bdi>Désolé!</bdi></strong>
 Il n'y a pas des données disponible ici. Veuillez ajouter votre <b><a href="{{URL::route('indexEtudiant')}}" class="underline">étudiants</a></b>.  
<button type="button" class="dismiss la la-times" data-dismiss="alert"></button>
</div>
@endif     
@include('backend.pages.footer')
</main>
@include('backend.admin.pedagogie.Etudiants.formAdd')
@stop