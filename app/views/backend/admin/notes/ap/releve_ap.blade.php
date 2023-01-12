<?php 
$path = Session::get('language');
$control = Control::find(1); 
?> 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Releve des notes - {{$class->name.' '.$student->fname.' '.$student->lname.' '.$years->yearsUniv}}</title>
    <!-- Generics -->
    <link rel="icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="32x32">
    <link rel="icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="128x128">
    <link rel="icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="192x192">
    <!-- Android -->
    <link rel="shortcut icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="196x196">
    <!-- iOS -->
    <link rel="apple-touch-icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="167x167">
    <link rel="apple-touch-icon" href="{{ url() }}/public/uploads/favicon/{{$control->favicon}}" sizes="180x180">
    {{ HTML::style('public/assets/css/style.css') }}



   <style>
     @media print {
      #sidebar-menu, #desktop-menu, footer, #btn-invoice {
        display: none;
      }
     .container {
        margin-top:2px;
        padding-top: 0;
    }

    .footer_tb {
        padding-bottom: 12px;
        margin-top: 20px;
    }

     body[size="A4"] {
        margin: 0;
        box-shadow: 0;
        color:#000;
        line-height: 80%; text-align: justify; background: transparent
      }
     
     }
    
    @page {
        /*size: 7in 9.25in;*/
        size: 21cm 29.7cm; margin: 2cm
        width: 5rem;
        card: nonre;
        line-height: 120%; text-align: justify; background: transparent
    }
    

  </style>  
</head>
<body style="color:#000">
    <!-- Top Bar -->
    <section class="top-bar" id="btn-invoice">
        <!-- Brand -->
        <span class="brand">ESIGE Mahajanga</span>
        <nav class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Fullscreen -->
            <button id="fullScreenToggler" type="button"
                class="hidden lg:inline-block btn-link ltr:ml-5 rtl:mr-5 text-2xl leading-none la la-expand-arrows-alt"
                data-toggle="tooltip" data-tippy-content="Fullscreen"></button>
            <!-- Register -->
            <button type="button" id="btn-invoice" onclick="window.print();" class="badge badge_secondary ltr:ml-5 rtl:mr-5" style="color:#fff"><span class="la la-print text-xl"></span> Imprimer</button>
        </nav>
    </section>

@if(count($myNote)> 0)

    <div class="container flex items-center justify-center mt-20 py-10">
    <div>
    <div class="border p-3">
    <span class="flex items-center justify-center">
        <div class="text-xl font-bold">
            <img class="inline-block w-5 h-auto mr-5" src="{{ url() }}/public/uploads/logo/{{$control->logo}}" style="float:left">
        </div>
    <center>   
    <h4 class="" style="color:#000; font-family:TimesNewRoman, sans-serif;  ; letter-spacing:0.1rem !important;line-height:1.1rem;">
        REPOBLIKAN'I MADAGASIKARA<br>
        <small style="font-size:0.6rem;color:#000;">Fitiavana - Tanindrazana - Fandrosoana</small>
        <hr class="border-dashed">
        Ministère de l'Enseignement Supérieur <br>et de la Recherche Scientifique
        <hr class="border-dashed">
        Ecole Supérieur d'Informatique et de Gestion des Entreprises
        <center>E.S.I.G.E</center>
        <hr class="border-dashed">
        <small style="font-size:0.6rem;color:#000;font-family:Arial, Helvetica, sans-serif;">Etablissement habilité par MESupRES et homologué par la Fonction Publique</small>
    </h4>
    </center>
    </span>
<hr>
    <div class="px-7 py-2 flex justify-between">
        <div>
            <p class="leading-relaxed">@if($student->sexe == 1)Mr.@else Mme/Mlle. @endif {{$student->fname}} {{$student->lname}}<br>
                Né(e) le: {{$student->birth}} à {{$student->birthLocation}}<br>
                Sexe:@if($student->sexe == 1) Masculin @else Féminin @endif<br>
               </p>
        </div>
        <center class="pb-0">
        <br>
        <h5>RELEVE DES NOTES</h5>
        <p>Année d'étude - {{$years->yearsUniv}}</p>
        </center>
        <div class="ltr:text-right rtl:text-left">
            <p class="leading-relaxed">Niveau: @if($student->grade == NULL){{$class->name}} @else Auditeur Libre @endif<br>
             N° matricule: {{$student->matricule}}</p>
        </div>
    </div>    
    <table width="730" border=1>
    <thead>
      <tr style="line-height:12px;">
        <td align="left" width="380">Unités d'enseignement</td>
        <td align="left" width="380">Elements Constitutif</td>
        <td>Notes/20 </td>
        <td>Observation </td>
      </tr>
    </thead>

    <tbody>

    @foreach($myNote as $rvnote)
    <?php  

        $mat        = EC::where('codeUe', $rvnote->codeUe)
                    //->where('id', $rvnote->element_id)
                    ->where('class_id', $rvnote->class_id)
                    ->groupBy('codeEc')
                    ->get();

        $sumCoef_1  = DB::table('elements')->where('class_id', $class->id)
                         ->where('codeEc', $rvnote->codeEc)
                         ->sum('coef');

        $ues       = UE::where('codeUe', $rvnote->codeUe)
                         ->where('class_id', $rvnote->class_id)
                         ->groupBy('name')
                         ->first();

        $Noty     = Note::where('class_id', $rvnote->class_id)
                        ->where('id_student', $student->id)
                        ->where('codeUe', $rvnote->codeUe)
                        ->orderBy('codeEc')
                        ->groupBy('codeEc')
                        ->get(); 
        
        //Somme UE 
        $SumUe      = DB::table('notes')
                        ->where('class_id', $rvnote->class_id)
                        ->where('id_student', $student->id)
                        ->where('codeUe', $rvnote->codeUe)
                        ->where('codeEc', $rvnote->codeEc)
                        ->groupBy('codeUe')
                        ->sum('note');
        //Total EC                
        $CountEc     = DB::table('notes')
                        ->where('class_id', $rvnote->class_id)
                        ->where('id_student', $student->id)
                        ->where('codeUe', $rvnote->codeUe)
                        ->where('codeEc', $rvnote->codeEc)
                        ->groupBy('codeUe')
                        ->count(); 
       
       // Equation UE / EC - Exemple: 65/4 = 16.25
       $cost        = $SumUe/$CountEc; 

    ?>                  
      <tr>
        <td>{{$ues->name}}</td>
        <td>
        <table class="table_bordered" width="100%">  
          @foreach($mat as $mate)
          <?php $purg = Note::where('codeEc', $mate->codeEc)->first() ?>
          @if(!empty($purg->codeEc))
          <tr style="line-height:12px;">
            <td>{{$mate->name}}</td>
          </tr>
          @endif
          @endforeach  
        </table>
        </td>
         <td>
         <table class="table_bordered" width="100%">
         @foreach($Noty as $noty) 
          <tr style="line-height:12px;" align="center">
            <td>{{number_format($noty->note, 2, ',', '')}}</td>
          </tr>
          @endforeach  
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
          <tr style="line-height:12px;">
            <td>@if($cost >= 10) Validé @else <span style="color:red">Non validé</span> @endif</td>
          </tr>
        </table>
        </td>
      </tr>
    @endforeach
    </tbody>
    <tfoot style="line-height:12px;">
      <tr>
        <td colspan="2" class="footer_table" style="text-align:left;">Total générale</td>
        <td align="center"><b>{{number_format($totalNote, 2, ',', '')}}</b></td>
        <td></td>
      </tr>
      <tr style="font-weight:bold;">
         <td colspan="2">Moyenne génerale sur 20</td>
         <td align="center">{{number_format($Moyenne, 2, ',', '')}}/20</td>
         <td></td>
      </tr>
       <tr>
         <td scope="col" colspan="4" style="line-height:14px;">
            <p style="text-align:left;"><b>Observation finale</b>:<span style="text-align:center;">
            @if($Moyenne >= 10) Admis en @if($student->niveau->short =='AP') Licence 1 @elseif($student->niveau->short == 'L1') Licence 2 @endif professionnel avec la mention 
            
            @if($Moyenne <= 11.99)<b>Passable</b> 

            @elseif($Moyenne <= 13.99)<b>Assez-Bien</b> 

            @elseif($Moyenne <= 15.99) <b>Bien</b> 

            @elseif($Moyenne >= 16) <b>Très-Bien</b> 

            @endif

            @else 
            <span style="color:red">Etudiant non admis en @if($student->niveau->short =='AP') Licence 1 @elseif($student->niveau->short == 'L1') Licence 2 @endif</span> 
            @endif
            </span></p>
        </td>
      </tr>
    </tfoot>
  </table>  
  <div class="px-3 py-0 flex justify-between">
    <p class="mt-2" style="font-family:Arial Narrow, sans-serif;"><b><u>Note importante</u></b><br>
    <small style="text-align:center;line-height:-1px">Ce relevé de notes ne doit être remis <br style="line-height:-1rem">en aucun cas à l’intéressé sous <br> peine d’annulation.</small>
    </p>  
    <p class="mt-2" style="font-family:Arial Narrow, Arial, sans-serif;"><b>Fait à Mahajanga, le__________________</b><br>
  </div>
 
  <br><br><br><br>
  <hr class="border-dashed mt-5">
  <center class="text-sm mt-5">
    <small class="footer_tb">
      B.P: 448 Tsararano Ambony-401 Mahajanga <br>
      Tél: 020 62 925 - +261 34 11 215 51 - +261 32 04 582 81 <br>
      Email: esige2003@yahoo.com
    </small>
  </center>
</div>
</div>
</div>

<style type="text/css">
td {
  border: 0px solid #726E6D;
  padding: 3px;
}

thead{
  font-weight:bold;
  text-align:center;
  background: #fff;
  color:#000;
}

table {
  border-collapse: collapse;
  border: 1;
}

.footer_table {
  text-align:right;
  font-weight:bold;
}

tbody >tr:nth-child(odd) {
  background: #fff;
}
table {
    border-collapse: collapse       
}

td {
   border: 1px solid #000000
}
</style>
@else
@endif
<script src="{{ url() }}/public/assets/js/facture.js"></script>
</body>
</html>