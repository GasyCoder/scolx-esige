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
    <title>Relevé des notes - {{$student->niveau->short.'-'.$student->fname.' '.$student->lname.' '.$years->yearsUniv}}</title>
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
        size: 21cm 29.7cm; margin: 1cm;
        margin-top: 20px;
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
            <button type="button" id="btn-invoice" onclick="window.print();" class="badge badge_success ltr:ml-5 rtl:mr-5" style="color:#fff"><span class="la la-print text-xl"></span> Imprimer</button>
        </nav>
    </section>


<?php $mention = Mention::where('class_id', $student->class_id)->where('parcour_id', $student->parcour_id)->first();?>

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
        <h5>RELEVE DES NOTES</h5>
        <p>Année d'étude - {{$years->yearsUniv}}</p>
            <hr class="border-dashed">
            Niveau: @if($student->grade == NULL) {{$class->name}} @else {{$class->short}}-Auditeur Libre @endif -  
            @if($student->niveau->short == 'L1') 
            (S1-S2) 
            @endif
        </center>
        <div class="ltr:text-right rtl:text-left">
            <p class="leading-relaxed">
            N° matricule: {{$student->matricule}}   
            <br>
            Mention: {{$mention->name}} <br>
            Parcour: {{$student->parcour->abr}}</p>
        </div>
    </div>    
    <table width="740" border=1>
    <thead>
      <tr style="line-height:12px;">
        <td align="left" width="380">Unités d'enseignement</td>
        <td align="left" width="380">Elements Constitutif</td>
        <td>Notes/20 </td>
        <td>Coef</td>
        <td>Total</td>
        <td width="150">Note max</td>
        <td>Observation</td>
      </tr>
    </thead>
    <tbody>
    <?php 
        $sommeX     = 0;//SOMME TOTAL   
        $sommenotemaY     = 0;      
    ?>
     <tr>
         <td colspan="7" style="text-align:center;font-weight:bold;">Premiere Semestre</td>
      </tr>   
    @foreach($myNote_s1 as $rvnote)
     <?php  

        $matieres       = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->groupBy('codeEc')
                                ->get();   

        $lefts          = DB::table('elements')
                                ->leftJoin('notesexam', 'elements.codeUe', '=', 'notesexam.codeUe')
                                //->select('notes', 'elements.parcour_id', '=', 'notes.parcour_id')
                                ->first();

        /*$coefs_s1       = EC::where('codeUe',           $rvnote->codeUe)
                                ->where('class_id',     $rvnote->class_id)
                                ->where('parcour_id',   $rvnote->parcour_id)
                                ->groupBy('codeEc')
                                ->get();*/

        $noteEtu        = Credit::where('id_student',   $rvnote->id_student)
                                ->where('class_id',     $rvnote->class_id)
                                ->where('parcour_id',   $rvnote->parcour_id)
                                ->where('codeUe',       $rvnote->codeUe)
                                ->where('semestre', 1)
                                ->orderBy('codeEc')
                                ->get(); 
                       

        $CoefPondere     = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->groupBy('codeUe')
                                ->sum('coef');            

        $ues            = UE::where('codeUe', $rvnote->codeUe)
                                 ->where('class_id', $rvnote->class_id)
                                 ->groupBy('name')
                                 ->first(); 
                                                
        $sumEc          = DB::table('notesexam')
                                ->where('class_id', $rvnote->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $rvnote->codeUe)
                                ->groupBy('codeEc')
                                ->sum('noteExam');

        $Sumues         = DB::table('notesexam')
                                ->where('class_id', $rvnote->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $rvnote->codeUe)
                                ->groupBy('codeEc')
                                ->get(); 

       //$cost        = $sumUe/$sumEc;                                    
    ?> 
                  
      <tr style="color:#0C4A6E;">
        <td>{{$ues->codeUe}}: {{$ues->name}}</td>
        <td>
        <table class="table_bordered" width="100%">  
          @foreach($matieres as $mate)
          <?php $purg = Credit::where('codeEc', $mate->codeEc)->first() ?>
          @if(!empty($purg->codeEc))
          <tr style="line-height:12px;text-transform:;">
            <td>{{$mate->name}}</td>
          </tr>
          @endif
          @endforeach
        </table>
        </td>
         <td>
         <table class="table_bordered" width="100%">
            @foreach($noteEtu as $noty)
              <tr style="line-height:12px;" align="center">
                <td>{{number_format($noty->NoteEc, 2, ',', '')}}</td>
              </tr>
            @endforeach  
        </table>
        </td>
        <td>
         <table class="table_bordered" width="100%">
            @foreach($noteEtu as $notyCoef)
              <tr style="line-height:12px;" align="center">
              <td>{{$notyCoef->coef}}</td>
              </tr>
            @endforeach 
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
        <?php
            $totalPondere   = 0;    
        ?>
        @foreach($noteEtu as $note)
        <?php 
            $NotePondere       = $note->Noteponder;
            $totalPondere     += $NotePondere;
        ?> 
          <tr style="line-height:12px;" align="center">
            <td>{{number_format($NotePondere, 2, ',', '')}}</td> 
          </tr>
        @endforeach 
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
        <?php
            $totalnotemax   = 0;    
        ?>    
        @foreach($noteEtu as $notemaxim)
            <?php 
            $notemax        = $notemaxim->coef*20;
            $totalnotemax  += $notemax;
            ?>
              <tr style="line-height:12px;" align="center">
              <td>{{$notemax}}</td>
              </tr>
        @endforeach 
        </table>
        </td>
        <td>    
        <table class="table_bordered" width="100%">
        <?php $isvalide = $totalPondere/$CoefPondere ?>
          <tr style="line-height:12px;">
            @if($isvalide >= 10)
            <td> Validé @else <span style="color:red">Non validé</span><br></td>
            @endif
          </tr>
        </table>
        </td>
      </tr>
    <?php 
        $sommeX         += $totalPondere; //calcul Somme Total note ponderée
        $sommenotemaY   += $totalnotemax;
    ?>
    @endforeach

      <tr style="font-weight:500;">
        <td colspan="2" class="" style="text-align:left;">Total notes 1<sup>er</sup> semestre</td>
        <td align="center"></td>
        <?php 
         $SomCoefx   = Credit::where('id_student', $rvnote->id_student)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                ->where('semestre', 1)
                                ->groupBy('class_id')
                                ->sum('coef');
        ?>
        <td align="center" style="color:#0C4A6E;">{{$SomCoefx}}</td>

        <td align="center" style="color:#0C4A6E;">{{number_format($sommeX, 2, ',', '')}}</td>

        <td align="center" style="color:#0C4A6E;">{{$sommenotemaY}}</td>
        <td></td>
      </tr>
      <tr style="font-weight:500;">
         <td colspan="4">Moyenne  1<sup>er</sup> semestre</td>
         <?php $moyenne_s1 =  $sommeX/$SomCoefx; ?>
         <td align="center" style="color:#0C4A6E;">{{number_format($moyenne_s1, 2, ',', '')}}</td>
         <td></td>
         <td></td>
      </tr>
    </tbody>

            <!--SEMESTRE 2 -->

    <tbody>
    <?php 
        $somme            = 0;//SOMME TOTAL   
        $sommenotemax     = 0;      
    ?>
     <tr>
         <td colspan="7" style="text-align:center;font-weight:bold;">Deuxième Semestre</td>
      </tr>   
    @foreach($myNote_s2 as $note_s2)
      <?php  

        $matieres       = EC::where('codeUe', $note_s2->codeUe)
                                ->where('class_id', $note_s2->class_id)
                                ->where('parcour_id', $note_s2->parcour_id)
                                ->where('semestre', 2)
                                ->groupBy('codeEc')
                                ->get();   

        $lefts          = DB::table('elements')
                                ->leftJoin('notesexam', 'elements.codeUe', '=', 'notesexam.codeUe')
                                //->select('notes', 'elements.parcour_id', '=', 'notes.parcour_id')
                                ->first();

        /*$coefs_s1       = EC::where('codeUe',           $rvnote->codeUe)
                                ->where('class_id',     $rvnote->class_id)
                                ->where('parcour_id',   $rvnote->parcour_id)
                                ->groupBy('codeEc')
                                ->get();*/

        $noteEt        = Credit::where('id_student',     $note_s2->id_student)
                                ->where('class_id',     $note_s2->class_id)
                                ->where('parcour_id',   $note_s2->parcour_id)
                                ->where('codeUe',       $note_s2->codeUe)
                                ->where('semestre', 2)
                                ->orderBy('codeEc')
                                ->get(); 
                       

        $CoefPondere     = EC::where('codeUe', $note_s2->codeUe)
                                ->where('class_id', $note_s2->class_id)
                                ->where('parcour_id', $note_s2->parcour_id)
                                ->groupBy('codeUe')
                                ->sum('coef');            

        $ues            = UE::where('codeUe', $note_s2->codeUe)
                                 ->where('class_id', $note_s2->class_id)
                                 ->groupBy('name')
                                 ->first(); 
                                                
        $sumEc          = DB::table('notesexam')
                                ->where('class_id', $note_s2->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $note_s2->codeUe)
                                ->groupBy('codeEc')
                                ->sum('noteExam');

        $Sumues         = DB::table('notesexam')
                                ->where('class_id', $note_s2->class_id)
                                ->where('id_student', $student->id)
                                ->where('codeUe', $note_s2->codeUe)
                                ->groupBy('codeEc')
                                ->get(); 

       //$cost        = $sumUe/$sumEc;                                    
    ?> 
                  
      <tr style="color:#0C4A6E;">
        <td>{{$ues->codeUe}}: {{$ues->name}}</td>
        <td>
       <table class="table_bordered" width="100%">  
          @foreach($matieres as $mate)
          <tr style="line-height:12px;text-transform:;">
            <td>{{$mate->name}}</td>
          </tr>
          @endforeach
        </table>
        </td>
         <td>
         <table class="table_bordered" width="100%">
            @foreach($noteEt as $noti)
              <tr style="line-height:12px;" align="center">
                <td>{{number_format($noti->NoteEc, 2, ',', '')}}</td>
              </tr>
            @endforeach
        </table>
        </td>
        <td>
         <table class="table_bordered" width="100%">
            @foreach($noteEt as $notyCoef)
              <tr style="line-height:12px;" align="center">
              <td>{{$notyCoef->coef}}</td>
              </tr>
            @endforeach   
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
        <?php
            $totalPondere   = 0;    
        ?>
        @foreach($noteEt as $noter)
        <?php 
            $NotePondere       = $noter->Noteponder;
            $totalPondere     += $NotePondere;
        ?> 
          <tr style="line-height:12px;" align="center">
            <td>{{number_format($NotePondere, 2, ',', '')}}</td> 
          </tr>
        @endforeach 
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
        <?php
            $totalnotemax   = 0;    
        ?>    
        @foreach($noteEt as $notemaxim)
            <?php 
            $notemax = $notemaxim->coef*20;
            $totalnotemax  += $notemax;
            ?>
              <tr style="line-height:12px;" align="center">
              <td>{{$notemax}}</td>
              </tr>
        @endforeach 
        </table>
        </td>
        <td>    
        <table class="table_bordered" width="100%">
        <?php $isvalide = $totalPondere/$CoefPondere ?>
          <tr style="line-height:12px;">
            @if($isvalide >= 10)
            <td> Validé @else <span style="color:red">Non validé</span><br></td>
            @endif
          </tr>
        </table>
        </td>
      </tr>
    <?php 
        $somme += $totalPondere; //calcul Somme Total note ponderée
        $sommenotemax += $totalnotemax;
    ?>
    @endforeach
      <tr style="font-weight:500;">
        <td colspan="2" class="" style="text-align:left;">Total notes 2<sup>ème</sup> semestre</td>
        <td align="center"></td>
        <?php $SomCoefTo = Note::where('id_student', $rvnote->id_student)
                                ->where('class_id', $rvnote->class_id)
                                ->where('parcour_id', $rvnote->parcour_id)
                                 ->where('semestre', 2)
                                ->groupBy('class_id')
                                ->sum('coef');
        ?>
        <td align="center" style="color:#0C4A6E;">{{$SomCoefTo}}</td>
        <td align="center" style="color:#0C4A6E;">{{number_format($somme, 2, ',', '')}}</td>
        <td align="center" style="color:#0C4A6E;">{{$sommenotemax}}</td>
        <td></td>
      </tr>
      <tr style="font-weight:500;">
         <td colspan="4">Moyenne  2<sup>ème</sup> semestre</td>
         <?php $moyenne_s2 =  $somme/$SomCoefx; ?> 
         <td align="center" style="color:#0C4A6E;">{{number_format($moyenne_s2, 2, ',', '')}}</td>
         <td></td>
         <td></td>
      </tr>
    </tbody>
    <tr>
        <td colspan="7"></td>
    </tr> 
    <tfoot style="line-height:12px;">
        <?php $sommeMoyenne =  $moyenne_s1+$moyenne_s2; ?>
      <tr>
        <td colspan="4" class="footer_table" style="text-align:left;">Total moyenne S1 et S2</td>
        <td align="center" style="color:#0C4A6E;"><b>{{number_format($sommeMoyenne, 2, ',', '')}}</b></td>
        <td></td>
        <td></td>
      </tr>
      <tr style="font-weight:bold;">
         <td colspan="4">Moyenne génerale sur 20</td>
         <?php $moyenne =  $sommeMoyenne/2; ?>
         <td align="center" style="color:#0C4A6E;">{{number_format($moyenne, 2, ',', '')}}</td>
         <td></td>
         <td></td>
      </tr>
       <tr>
         <td scope="col" colspan="7" style="line-height:14px;">
            <p style="text-align:left;"><b>Observation finale</b>:<span style="text-align:center;">
            @if($moyenne >= 10) Admis en @if($student->niveau->short =='L1') Licence 2 @elseif($student->niveau->short == 'L2') Licence 3 @elseif($student->niveau->short =='L3') Master 1 @elseif($student->niveau->short =='M1') Master 2 @endif professionnel avec la mention 

                @if($moyenne >= 10 && $moyenne <= 11.99)
                    <b class="text-blue-700">Passable</b> 
                    @elseif($moyenne >= 12 && $moyenne <= 13.99)
                    <b class="text-blue-700">Assez-Bien</b> 
                    @elseif($moyenne >= 14 && $moyenne <= 15.99) 
                    <b class="text-green-700">Bien</b> 
                    @elseif($moyenne >= 16) 
                    <b class="text-green-700">Très-Bien</b> 
                @endif
            @else 
            <span style="color:red">Etudiant non admis en @if($student->niveau->short =='L1') Licence 2 @elseif($student->niveau->short == 'L2') Licence 3 @elseif($student->niveau->short =='L3') Master 1 @elseif($student->niveau->short =='M1') Master 2 @endif</span> 
            @endif
            </span></p>
        </td>
      </tr>
    </tfoot>
  </table>  
  <div class="px-3 py-0 flex justify-between" style="line-height:1.1rem;">
    <p class="mt-2" style="font-family:Arial Narrow, sans-serif;"><b><u>Note importante</u></b><br>
    <small>Ce relevé de notes ne doit être remis <br>en aucun cas à l’intéressé sous <br> peine d’annulation.</small>
    </p>  
    <p class="mt-2" style="font-family:Arial Narrow, Arial, sans-serif;"><b>Fait à Mahajanga, le__________________</b><br>
  </div>
  <br><br>
  <hr class="border-dashed mt-5">
  <center class="text-sm mt-1" style="line-height:0rem;">
    <small class="footer_tb" style="line-height:0.7rem">
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
  padding: 0px;
}

thead{
  font-weight:bold;
  text-align:center;
  background: #fff;
  color:#000;
}

table {
  border-collapse: collapse;
  border: 0;
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
   border: 1px solid #1d396c
}
</style>
@section('js')
<script src="{{ url() }}/public/assets/js/facture.js"></script>
@endsection
</body>
</html>