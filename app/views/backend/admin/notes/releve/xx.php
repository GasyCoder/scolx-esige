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
    <title>Releve des notes - {{$student->niveau->name}}|{{$student->fname}}</title>
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
         margin-top: 30px;
        padding-top: 0;
    }

     body[size="A4"] {
        margin: 0;
        box-shadow: 0;
        color:#000;
        line-height: 120%; text-align: justify; background: transparent
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

@if(count($note_X)>0)

<?php $mention = Mention::where('class_id', $student->class_id)->where('parcour_id', $student->parcour_id)->first();?>

    <div class="container flex items-center justify-center mt-20 py-10">
    <div class="" width=680 >
    <div class="border p-5">
    <span class="flex items-center justify-center">
        <div class="text-xl font-bold mb-1">
            <img class="inline-block w-8 h-auto mr-5 shadow-xl rounded-xl" src="{{ url() }}/public/uploads/logo/{{$control->logo}}" style="float:left">
        </div>
    <center>    
    <h4 class="" style="color:#000; font-family:Arial, Helvetica, sans-serif;">
        REPOBLIKAN'I MADAGASIKARA<br>
        <small style="font-size:0.6rem;color:#000;">Fitiavana - Tanindrazana - Fandrosoana</small>
        <hr class="border-dashed">
        Ministère de l'Enseignement Supérieur <br>et de la Recherche Scientifique
        <hr class="border-dashed">
        Ecole Supérieur d'Informatique et de Gestion des Entreprises
        <center>E.S.I.G.E</center>
        <hr class="border-dashed">
        <small style="font-size:0.6rem;color:#000;font-family:Arial, Helvetica, sans-serif;">Etablissement habilité par MESupRES et hologué par la Fonction Publique</small>
    </h4>
    </center>
        <!--<div class="text-xl font-bold mb-1 ml-0">
            {{ QrCode::encoding("UTF-8")->size(120)->generate(
                    'Facture N°:'.         ' | ' 
                    .'Date:'.              ' ' .\Carbon\Carbon::parse($control->created_at)->format('d/m/y').           ' | ' 
                    .'Classe:'.            
                    ' | '  .'Ecole:'.      ' ' .'ESIGE MAHAJANGA');}}
        </div>-->
    </span>
<hr>
    <div class="px-8 py-3 flex justify-between">
        <div>
            <p class="leading-relaxed">@if($student->sexe == 1)Mr.@else Mme/Mlle. @endif {{$student->fname}} {{$student->lname}}<br>
                Né(e) le: {{$student->birth}} à {{$student->birthLocation}}<br>
                Sexe:@if($student->sexe == 1) Masculin @else Féminin @endif<br>
                N° matricule: {{$student->matricule}}</p>
        </div>
        <center class="pb-5">
        <br>
        <strong>RELEVE DES NOTES</strong>
        <p>Année d'étude - {{$years->yearsUniv}}</p>
        </center>
        <div class="ltr:text-right rtl:text-left">
            <p class="leading-relaxed">Niveau: {{$student->niveau->name}}<br>
                Mention:{{$mention->name}} <br>
                Parcour: {{$student->parcour->abr}}</p>
        </div>
    </div>    
    <table class="w-full" border=1 cellpadding=0 cellspacing=0>
    <thead>
      <tr style="line-height:2px;">
        <td align="left" style="line-height:2px;">Matières</td>
        <td>Notes/20 </td>
        <!--<td>Coef</td>-->
        <td>Observation </td>
      </tr>
      <tr>
        <td colspan="4" style="background:#D1D0CE;text-align:center;font-weight:bold;">
            <div style="line-height:2px;">
            @if($class->short == 'L1') Semestre 1 @elseif($class->short == 'L2') Semestre 3 @elseif($class->short == 'L3') Semestre 5 @elseif($class->short == 'M1') Semestre 7 @elseif($class->short == 'M2') Semestre 9 @endif
            </div>
        </td>
      </tr>
    </thead>
    <tbody>
    @foreach($note_X as $rvnote_1)
    <?php 
        $student   = Etpresent::where('class_id', $rvnote_1->class_id)
                                ->where('id', $rvnote_1->id_student)->first(); 
        $matiere   = EC::where('codeEc', $rvnote_1->codeEc)->first();
        $sumCoef_1 = DB::table('elements')->where('class_id', $class->id)
                         ->where('codeEc', $rvnote_1->codeEc)
                         ->sum('coef');
    ?>     
      <tr style="line-height:2px;">
        <td>{{$matiere->name}}</td>
        <td width="5" align="center">{{number_format($rvnote_1->note, 2, ',', '')}}</td>
        <!--<td width="5" align="center">{{$matiere->coef}}</td>-->
        <td width="5" align="center">@if($rvnote_1->note >= 10)Validé @else <span style="color:red">Non validé</span> @endif</td>
      </tr>
    @endforeach
    <tr style="line-height:2px;">
        <td colspan="1" class="footer_table" style="text-align:left;height:5px;" height="2">Total</td>
        <td align="center" height="2"><b>{{number_format($sumNote_1, 2, ',', '')}}</b></td>
        <!--<td align="center" height="2"><b>{{$sumCoef_1}}</b></td>-->
        <td></td>
    </tr>
    </tbody>
    
    <tr>
        <td colspan="4" style="background:#D1D0CE;text-align:center;font-weight:bold;color:#000;">
        <div style="line-height:2px;">    
       @if($class->short == 'L1') Semestre 2 @elseif($class->short == 'L2') Semestre 4 @elseif($class->short == 'L3') Semestre 5 @elseif($class->short == 'M1') Semestre 8 @elseif($class->short == 'M2') Semestre 10 @endif 
        </div>
        </td>
    <tbody>
    @foreach($note_Y as $rvnote_2) 
    <?php $student = Etpresent::where('class_id', $rvnote_2->class_id)
                                ->where('id', $rvnote_2->id_student)->first(); 
        $matiere = EC::where('codeEc', $rvnote_2->codeEc)->first();
        $sumCoef_2 = DB::table('elements')->where('class_id', $class->id)
                        ->where('codeEc', $rvnote_2->codeEc)
                        ->sum('coef');?>         
       <tr style="line-height:2px;">
        <td>{{$matiere->name}}</td>
        <td width="5" align="center">{{number_format($rvnote_2->note, 2, ',', '')}}</td>
        <!--<td width="5" align="center">{{$matiere->coef}}</td>-->
        <td width="5" align="center">@if($rvnote_2->note >= 10)Validé @else <span style="color:red">Non validé</span> @endif</td>
      </tr>
    @endforeach
    <tr style="line-height:2px;">
        <td colspan="1" class="footer_table" style="text-align:left;height:5px;" height="2">Total</td>
        <td align="center" height="2"><b>{{number_format($sumNote_2, 2, ',', '')}}</b></td>
        <!--<td align="center" height="2"><b>{{$sumCoef_2}}</b></td>-->
        <td></td>
    </tr>
    </tbody>
    </tr>
    <tfoot style="line-height:1px;">
      <tr style="background-color:#F3F4F6 line-height:2px;">
        <td colspan="4"></td>
      </tr>
      <tr>
        <td colspan="1" class="footer_table" style="text-align:left;">Total générale</td>
        <td align="center"><b>{{number_format($totalNote, 2, ',', '')}}</b></td>
        <!--<td align="center"><b>{{($sumCoef_1)+($sumCoef_2)}}</b></td>-->
        <td></td>
      </tr>
      <tr>
         <td scope="col" style="font-weight:bold;">Moyenne génerale sur 20</td>
         <td colspan="0" style="text-align:center;font-weight:bold;">{{number_format($Moyenne, 2, ',', '')}}/20</td>
         <td></td>
      </tr>
       <tr>
         <td scope="col" colspan="3" style="line-height:3px;">
            <p><b><u>Observation finale</u></b>:<span style="text-align:center;">
            @if($Moyenne >= 10) Admis en @if($student->niveau->short =='L1') Licence 2 @elseif($student->niveau->short == 'L2') Licence 3 @elseif($student->niveau->short =='L3') Master 1 @elseif($student->niveau->short =='M1') Master 2 @endif professionnel avec la mention 
            @if($Moyenne <= 12)<b>Assez-Bien</b> @elseif($Moyenne <=15) Bien @elseif($Moyenne >= 16) Très-Bien @endif
            @else 
            <span style="color:red">Etudiant non admis en @if($student->niveau->short =='L1') Licence 2 @elseif($student->niveau->short == 'L2') Licence 3 @elseif($student->niveau->short =='L3') Master 1 @elseif($student->niveau->short =='M1') Master 2 @endif</span> 
            @endif
            </span></p>
        </td>
      </tr>
    </tfoot>
  </table>  
  <div class="px-3 py-2 flex justify-between">
    <p class="mt-1" style="font-family:Arial Narrow, Arial, sans-serif;"><b><u>Note importante</u></b><br>
    <span style="text-align:center;line-height:-1px;"><small>Ce relevé de notes ne doit être remis <br>en aucun cas à l’intéressé sous <br> peine d’annulation.</small></span>
    </p>  
    <p class="mt-1" style="font-family:Arial Narrow, Arial, sans-serif;"><b>Fait à Mahajanga, le__________________</b><br>
  </div>
  <hr class="border-dashed mt-5">
  <center class="text-sm mt-2">
    <small>
      B.P: 448 Tsararano Ambony-401 Mahajanga <br>
      Tél: 020 62 925 - +261 34 11 215 51 - +261 32 04 582 81 <br>
      Email: esige2003@yahoo.com
    </small>
  </center>
</div>
</div>
</div>

<style type="text/css">
#table{
    max-width: 2480px;
    width:100%;
  }
#table td{
    width: auto;
    overflow: hidden;
    word-wrap: break-word;
}   
td {
  border: 1px solid #726E6D;
  padding: 15px;
}

thead{
  font-weight:bold;
  text-align:center;
  background: #fff;
  color:#000;
}

table {
  border-collapse: collapse;
}

.footer_table {
  text-align:right;
  font-weight:bold;
}

tbody >tr:nth-child(odd) {
  background: #fff;
}   
</style>
@else
@endif
<script src="{{ url() }}/public/assets/js/facture.js"></script>
</body>
</html>