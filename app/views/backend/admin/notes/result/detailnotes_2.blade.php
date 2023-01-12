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
    <title>Détails notes | Semestre 2</title>
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
        <span class="brand">SCOLX</span>
        <nav class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Fullscreen -->
            <button id="fullScreenToggler" type="button"
                class="hidden lg:inline-block btn-link ltr:ml-5 rtl:mr-5 text-2xl leading-none la la-expand-arrows-alt"
                data-toggle="tooltip" data-tippy-content="Fullscreen"></button>
            <!-- Register -->
            <button type="button" id="btn-invoice" onclick="window.print();" class="badge badge_success ltr:ml-5 rtl:mr-5" style="color:#fff"><span class="la la-print text-xl"></span> Imprimer</button>
        </nav>
    </section>
<?php $mention = Mention::where('parcour_id', $student->parcour_id)->first();?>
    <div class="container flex items-center justify-center mt-20 py-10">
    <div>
        <div class="border p-5">
    <center class="pb-0">
        <h3>SESSION 1</h3>
        <h5>DEUXIEME SEMESTRE</h5>
        <p>Année d'étude - {{$years->yearsUniv}}</p>
            <hr class="border-dashed">
            Niveau: @if($student->grade == NULL) {{$class->name}} @else {{$class->short}}-Auditeur Libre @endif 
            @if($student->niveau->short == 'L1') 
            @endif
        </center>  
        <hr class="border-dashed mb-5">  
    <div class="px-7 py-2 justify-between">
        <div>
            <p class="leading-relaxed">@if($student->sexe == 1)Mr.@else Mme/Mlle. @endif {{$student->fname}} {{$student->lname}}<br>
                Né(e) le: {{$student->birth}} à {{$student->birthLocation}}<br>
                Sexe:@if($student->sexe == 1) Masculin @else Féminin @endif<br>
                </p>
        </div>
        <div class="ltr:text-right rtl:text-left">
            <p class="leading-relaxed">
            N° matricule: {{$student->matricule}}   
            <br>
            Mention: {{$mention->name}} <br>
            Parcours: {{$student->parcour->abr}}</p>
        </div>
    </div>    
 
    <table class="" width="740" border=1>
    <thead>
      <tr style="line-height:12px;">
        <td align="left" width="380">UE</td>
        <td align="left" width="380">EC</td>
        <td width="350">Notes CC+Examen </td>
        <td>Coef</td>
        <td>Pondéré</td>
        <td>Observation</td>
      </tr>
    </thead>
    <tbody>
    <?php 
        $sommeX     = 0;//SOMME TOTAL   
        $sommenotemaY     = 0;      
    ?> 
    @foreach($detailNotes as $rvnote)
     <?php  

        $matieres       = EC::where('codeUe', $rvnote->codeUe)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->groupBy('codeEc')
                                ->get();   


        $noteEtu        = Credit::where('id_student',   $rvnote->id_student)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('codeUe',       $rvnote->codeUe)
                                ->where('semestre', 2)
                                ->where('session', 1)
                                ->orderBy('codeEc')
                                ->get(); 
                       

        $CoefPondere     = EC::where('codeUe',          $rvnote->codeUe)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('semestre', 2)
                                ->groupBy('codeUe')
                                ->sum('coef');            

        $ues            = UE::where('codeUe',            $rvnote->codeUe)
                                 ->where('class_id',     $class->id)
                                 ->where('parcour_id',   $parcour->id)
                                 ->where('codeSem', 2)
                                 ->groupBy('name')
                                 ->first();                                 
    ?> 
                  
      <tr style="color:#0C4A6E;">
        <td><span class="font-bold">{{$ues->codeUe}}</span>: {{$ues->name}}</td>
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
        <?php $isvalide = $totalPondere/$CoefPondere ?>
          <tr style="line-height:12px;">
            @if($isvalide >= 10)
            <td style="color:green"> Validé @else <span style="color:red">Non validé</span><br></td>
            @endif
          </tr>
        </table>
        </td>
      </tr>
    <?php 
        $sommeX         += $totalPondere; //calcul Somme Total note ponderée
    ?>
    @endforeach

      <tr style="font-weight:500;">
        <td colspan="2" class="" style="text-align:left;">Total notes 2<sup>ème</sup> semestre</td>
        <td align="center"></td>
        <?php 
         $SomCoefx   = Credit::where('id_student',    $student->id)
                                ->where('class_id',   $class->id)
                                ->where('parcour_id', $parcour->id)
                                ->where('semestre', 2)
                                ->where('session', 1)
                                ->groupBy('class_id')
                                ->sum('coef');
        ?>
        <td align="center" style="color:#0C4A6E;">{{$SomCoefx}}</td>

        <td align="center" style="color:#0C4A6E;">{{number_format($sommeX, 2, ',', '')}}</td>
        <td></td>
      </tr>
      <tr style="font-weight:500;">
         <td colspan="4">Moyenne générale 2<sup>ème</sup> semestre</td>
         <?php $moyenne_s2 =  $sommeX/$SomCoefx; ?>
         <td align="center" style="color:#0C4A6E;">{{number_format($moyenne_s2, 2, ',', '')}}</td>
         <td></td>
      </tr>
    </tbody>
  </table>  
  @if($moyenne_s2 >= 10)
  <center style="color:green">
          Validé en 1ere session.
 </center>
 @else
 <center style="color:red">
         Passer en 2em session.
 </center>
 @endif
</div>
</div>
</div>

<style type="text/css">
td {
  border: 0px solid #726E6D;
  padding: 2px;
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
@if($check > 0)
<!-- Sidebar -->
    <aside class="sidebar" id="btn-invoice">
        <!-- Toggler - Mobile -->
        <button class="sidebar-toggler la la-ellipsis-v" data-toggle="sidebar"></button>
        <!-- Tags -->
       <h2 class="p-5">Semestre 1</h2>
        <hr>
         <div class="flex flex-col gap-y-5 p-5">
            <a href="/admin/detailnotes/semestre_1/niveau/etudiants/{{$rvnote->class_id.'/'.$rvnote->parcour_id.'/'.$rvnote->id_student}}" class="flex items-center text-normal">
                <span class="la la-check-circle text-2xl leading-none ltr:mr-2 rtl:ml-2"></span>
                Semestre 1
                <span class="badge badge_success ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto">
                Details</span>
            </a>
        </div>
    </aside>
@endif
</body>
</html>