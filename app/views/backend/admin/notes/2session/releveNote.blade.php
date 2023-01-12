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
<body style="color:#000;background:#fff;">
    <!-- Top Bar -->
    <section class="top-bar" id="btn-invoice">
        <!-- Brand -->
        <span class="brand">SCOLX</span>
        <nav class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Fullscreen -->
            <button id="fullScreenToggler" type="button"
                class="hidden lg:inline-block btn-link ltr:ml-5 rtl:mr-5 text-2xl leading-none la la-expand-arrows-alt"
                data-toggle="tooltip" data-tippy-content="Fullscreen"></button>
            <!-- Print -->
            <button type="button" id="btn-invoice" onclick="window.print();" class="badge badge_success ltr:ml-5 rtl:mr-5" style="color:#fff"><span class="la la-print text-xl"></span> Imprimer</button>
        </nav>
    </section>
    <?php $mention = Mention::where('parcour_id', $student->parcour_id)->first();?>
    <div class="container flex items-center justify-center mt-20 py-10">
    <div class="p-5">
    <span class="flex items-center justify-center">
    <center>   
    <img src="{{url()}}/public/assets/images/tete.png" style="width:43rem;height:6rem;">
    <hr class="border-dashed">
     <h5>RELEVE DES NOTES</h5>
    Niveau: 
    @if($student->grade == NULL) {{$class->name}} @else {{$class->short}}-Auditeur Libre @endif -  
    @if($student->niveau->short == 'L1') 
    (S1-S2) 
    <p>Année d'étude - {{$years->yearsUniv}} - <span style="border:1px dotted red">Session 2</span></p>
    @endif
    </center>
    </span>
    <div class="p-5 px-4 py-3">
    <div class="flex justify-between">
        <p class="leading-relaxed">@if($student->sexe == 1)Mr.@else Mme/Mlle. @endif {{$student->fname}} {{$student->lname}}<br>
            Né(e) le: {{$student->birth}} à {{$student->birthLocation}}<br>
            Sexe:@if($student->sexe == 1) Masculin @else Féminin @endif<br>
        </p>
    <div class="ltr:text-right rtl:text-left">
        <p class="leading-relaxed">
            N° matricule: {{$student->matricule}}   
            <br>
            Mention: {{$mention->name}} <br>
            Parcour: {{$student->parcour->abr}}
        </p>
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
    <?php $sommeX = 0; $sommenotemaY = 0;?>
     <tr>
         <td colspan="7" style="text-align:center;font-weight:bold;line-height:12px;background-color:#ddd;">PREMIER SEMESTRE</td>
     </tr>   
    @foreach($releves_s1 as $releve)
     <?php  
        $valMoyene1         = Credit::where('id_student', $student->id)
                                    ->where('class_id', $class->id)
                                    ->where('parcour_id', $parcour->id)
                                    ->where('yearsUniv', $years->yearsUniv)
                                    ->where('semestre', 1)
                                    ->where('session', 1)
                                    ->sum('Noteponder');
        $var1 = $valMoyene1/30;
        if($var1 >= 10) {
            $noteEtu        = Credit::where('id_student',   $student->id)
                                ->where('class_id',         $class->id)
                                ->where('parcour_id',       $parcour->id)
                                ->where('codeUe',           $releve->codeUe)
                                ->where('semestre', 1)
                                ->where('session', 1)
                                ->orderBy('codeEc')
                                ->get(); 
        }else{
            $noteEtu        = Credit::where('id_student',   $student->id)
                                ->where('class_id',         $class->id)
                                ->where('parcour_id',       $parcour->id)
                                ->where('codeUe',           $releve->codeUe)
                                ->where('semestre', 1)
                                ->where('session', 2)
                                ->orderBy('codeEc')
                                ->get();
        }

        $matieres       = EC::where('codeUe',           $releve->codeUe)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->groupBy('codeEc')
                                ->get();  

        $CoefPondere     = EC::where('codeUe',          $releve->codeUe)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('semestre', 1)
                                ->groupBy('codeUe')
                                ->sum('coef');            

        $ues            = UE::where('codeUe',           $releve->codeUe)
                                 ->where('class_id',    $class->id)
                                 ->where('parcour_id',  $parcour->id)
                                 ->groupBy('name')
                                 ->first(); 
                                  
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
        <?php $totalPondere = 0;?>
        @foreach($noteEtu as $note)
        <?php 
            $NotePondere  = $note->Noteponder;
            $totalPondere += $NotePondere;
        ?> 
          <tr style="line-height:12px;" align="center">
            <td>{{number_format($NotePondere, 2, ',', '')}}</td> 
          </tr>
        @endforeach 
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
        <?php $totalnotemax = 0;?>    
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
            <td align="center"> Validé </td>
             @else 
                 @if($valid > 0)
                 <td align="center"> Validé </td>
                 @else
             <td align="center"> <span style="color:red">Non validé</span><br></td>
                @endif
            @endif
          </tr>
        </table>

        </td>
      </tr>
    <?php $sommeX += $totalPondere; $sommenotemaY += $totalnotemax;?>
    @endforeach
      <tr style="font-weight:500;">
        <td colspan="2" class="" style="text-align:left;">Total notes 1<sup>er</sup> semestre</td>
        <td align="center"></td>
        <?php 
         $SomCoefx   = Credit::where('id_student',      $student->id)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('semestre', 1)
                                ->where('session', 2)
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
    <?php $somme = 0; $sommenotemax = 0;?>
     <tr>
         <td colspan="7" style="text-align:center;font-weight:bold;line-height:12px;background-color:#ddd;">DEUXIEME SEMESTRE</td>
      </tr>   
    @foreach($releves_s2 as $note_s2)
      <?php  
        $valMoyene2      = Credit::where('id_student', $student->id)
                                    ->where('class_id', $class->id)
                                    ->where('parcour_id', $parcour->id)
                                    ->where('yearsUniv', $years->yearsUniv)
                                    ->where('semestre', 2)
                                    ->where('session', 1)
                                    ->sum('Noteponder');
        $var2 = $valMoyene2/30;

        $matieres       = EC::where('codeUe',           $note_s2->codeUe)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('semestre', 2)
                                ->groupBy('codeEc')
                                ->get(); 

        if($var2 >= 10) {
            $noteEt        = Credit::where('id_student',    $student->id)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('codeUe',       $note_s2->codeUe)
                                 ->where('session', 1)
                                ->where('semestre', 2)
                                ->orderBy('codeEc')
                                ->get();   
        }else{
            $noteEt        = Credit::where('id_student',    $student->id)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('codeUe',       $note_s2->codeUe)
                                 ->where('session', 2)
                                ->where('semestre', 2)
                                ->orderBy('codeEc')
                                ->get(); 
        }

    
        $CoefPondere     = EC::where('codeUe',          $note_s2->codeUe)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->groupBy('codeUe')
                                ->sum('coef');            

        $ues            = UE::where('codeUe',           $note_s2->codeUe)
                                 ->where('class_id',    $class->id)
                                 ->where('parcour_id',  $parcour->id)
                                 ->groupBy('name')
                                 ->first();                      
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
        <?php $totalPondere = 0;?>
        @foreach($noteEt as $noter)
        <?php 
            $NotePondere   = $noter->Noteponder;
            $totalPondere += $NotePondere;
        ?> 
          <tr style="line-height:12px;" align="center">
            <td>{{number_format($NotePondere, 2, ',', '')}}</td> 
          </tr>
        @endforeach 
        </table>
        </td>
        <td>
        <table class="table_bordered" width="100%">
        <?php $totalnotemax = 0;?>    
        @foreach($noteEt as $notemaxim)
        <?php $notemax = $notemaxim->coef*20; $totalnotemax  += $notemax;?>
            <tr style="line-height:12px;" align="center">
              <td>{{$notemax}}</td>
            </tr>
        @endforeach 
        </table>
        </td>
        <td>    
        <table class="table_bordered" width="100%">
        <?php $isvalide = $totalPondere/$CoefPondere?>
          <tr style="line-height:12px;">
            @if($isvalide >= 10)
            <td align="center"> Validé </td>
             @else 
                 @if($valid > 0)
                 <td align="center"> Validé </td>
                 @else
             <td align="center"> <span style="color:red">Non validé</span><br></td>
                @endif
            @endif
          </tr>
        </table>
        </td>
      </tr>
    <?php $somme += $totalPondere; $sommenotemax += $totalnotemax;?>
    @endforeach
      <tr style="font-weight:500;">
        <td colspan="2" class="" style="text-align:left;">Total notes 2<sup>ème</sup> semestre</td>
        <td align="center"></td>
        <?php 
            $resultat = Result::where('id_student',   $student->id)
                                ->where('class_id',   $class->id)
                                ->where('parcour_id', $parcour->id)
                                //->where('admis', 1)
                                ->where('session', 2)
                                ->first();
        ?>
        <td align="center" style="color:#0C4A6E;">{{$SomCoefx}}</td>
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
         <td scope="col" colspan="7" style="line-height:14px;" align="center">
            <p style="text-align:left;"><b>Observation finale</b>:<span style="text-align:center;">
            @if($resultat->admis >= 1) Admis en 
                @if($class->short =='L1') Deuxième Année
                @elseif($class->short == 'L2') Troisième Année
                @elseif($class->short =='L3') Master première partie professionnel
                @elseif($class->short =='M1') Master deuxième partie professionnel
                @endif avec la mention 
                @if($moyenne >= $var && $moyenne <= 11.99)
                    <b class="text-blue-700">Passable</b> 
                    @elseif($moyenne >= 12 && $moyenne <= 13.99)
                    <b class="text-blue-700">Assez-Bien</b> 
                    @elseif($moyenne >= 14 && $moyenne <= 15.99) 
                    <b class="text-green-700">Bien</b> 
                    @elseif($moyenne >= 16) 
                    <b class="text-green-700">Très-Bien</b> 
                @endif
            @else 
                <span style="color:red;">Etudiant non admis en @if($class->short == 'L1') Deuxième Année 
                    @elseif($class->short == 'L2')  Licence 3 
                    @elseif($class->short == 'L3')  Master 1 
                    @elseif($class->short == 'M1')  Master 2 
                @endif
                </span>
            @endif
            </span></p>
        </td>
      </tr>
    </tfoot>
  </table><br>
  <div class="flex justify-between"> 
    <p style="margin-right:20rem;">
          {{ QrCode::encoding("UTF-8")->size(115)->generate(
          'Releve des notes'. ' | '
          .'N° matricule:'. ' ' .$student->matricule.        ' | '
          .'Nom:'.         ' ' .$student->fname.  ' | ' 
          .'Prenom:'.     ' '.$student->lname.   ' | ' 
          .'Niveau:'.     ' ' .$student->niveau->short. '-' .$student->parcour->abr. ' | ' 
          .'Promotion:'.  ' ' .$student->promo.   ' | ' 
          .'Université:'. ' ' .'ESIGE MAHAJANGA');
          }}
    </p>
    <p style="margin-left:3.2rem">Fait à Mahajanga, le_________________<br>
  </div>

<br><br><br><br><br>
<div class="footer flex items-center justify-center">
    <small style="line-height:0.7rem;">
    <i>Ce relevé de notes ne doit être remis en aucun cas à l’intéressé sous peine d’annulation.</i><hr> <br> 
      B.P: 448 Tsararano Ambony, Mahajanga-401, Madagascar<br>
      Tél: +261 34 11 215 51 | +261 32 04 582 81<br>
      Email: scolarite@esige.mg | Web: www.esige.mg
    </small>
</div>


</div>
</div>
</div>
<style type="text/css">
.footer {
       position: fixed;
       left: 0;
       padding-bottom: 0rem;
       bottom: 0rem;
       width: 100%;
       background-color: #fff;
       color: #000;
       text-align: center;
    }    
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