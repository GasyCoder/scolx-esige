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
    <title>Mode impression - Résultats d'examen 2ème Session </title>
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
        <span class="brand">SCOLX</span>
        <nav class="flex items-center ltr:ml-auto rtl:mr-auto">
            <!-- Fullscreen -->
            <button id="fullScreenToggler" type="button"
                class="hidden lg:inline-block btn-link ltr:ml-5 rtl:mr-5 text-2xl leading-none la la-expand-arrows-alt"
                data-toggle="tooltip" data-tippy-content="Fullscreen"></button>
            <!-- Register -->
            <button type="button" id="btn-invoice" onclick="window.print();" class="badge badge_secondary ltr:ml-5 rtl:mr-5" style="color:#fff"><span class="la la-print text-xl"></span> Imprimer</button>
        </nav>
    </section>
    <div class="container flex justify-center mt-20 py-10">
    <div class="border p-5">
    <span class="flex items-center justify-center">
        <div class="text-xl font-bold">
            <img class="inline-block w-5 h-auto mr-5" src="{{ url() }}/public/uploads/logo/{{$control->logo}}" style="float:left">
        </div>
    <center>   
    <h4 class="" style="color:#000; font-family:TimesNewRoman, sans-serif;  ; letter-spacing:0.1rem !important;line-height:1.1rem;">
        Ecole Supérieur d'Informatique et de Gestion des Entreprises
        <center>E.S.I.G.E</center>
        <hr class="border-dashed">
        <small style="font-size:0.6rem;color:#000;font-family:Arial, Helvetica, sans-serif;">Etablissement habilité par MESupRES et homologué par la Fonction Publique</small>
    </h4>
    </center>
    </span>
<hr>
    <div class="px-7 py-5 flex justify-center">
        <center class="pb-0">
        <br>
        <h5>RESULTATS DES EXAMENS</h5>
        <p class="font-bold">Liste des étudiants Rédoublants après la 2<sup>ème</sup> Session</p>
        <p>Niveau: <b>{{$class->short}}</b> | Parcours: <b>{{$parcour->abr}}</b></p>
        <p class="font-bold">Année d'étude - {{$years->yearsUniv}}</p>   
        <hr class="border-dashed">
        </center>
    </div>    
    <table class="p-5" width="740" border=1>
    <thead>
      <tr style="line-height:12px;">
        <td class="text-center">Rang</td>
        <td width="120">N° Matricule</td>
        <td align="left" width="380">Nom</td>
        <td align="left" width="380">Prénoms</td>
        <td>Observation</td>
      </tr>
    </thead>
    <tbody> 
    <?php $i = 1; ?> 
    @foreach($affichages as $affichage)
    <?php 
        $realPay = Pay::where('id_etudiant',            $affichage->id_student)
                                ->where('class_id',     $class->id)
                                ->where('parcour_id',   $parcour->id)
                                ->where('yearsUniv',    $affichage->yearsUniv)
                                ->sum('nbreMois'); 
    ?>     
      <tr>
        <td>{{$i++;}}</td>
        <td>{{$affichage->stud->matricule}}</td>
        <td>{{$affichage->stud->fname}}</td>
        <td>{{$affichage->stud->lname}}</td>
        <td class="text-center">
         @if($affichage->admis == 0)Rédoublant @endif
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>  
  <br><br><br><br>
  <hr class="border-dashed mt-5">
  <center class="text-sm mt-5" style="line-height:0.1rem;">
    <small class="footer_tb">
      B.P: 448 Tsararano Ambony-401 Mahajanga <br>
      Tél: 020 62 925 - +261 34 11 215 51 - +261 32 04 582 81 <br>
      Email: esige2003@yahoo.com
    </small>
  </center>
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
@section('js')
<script src="{{ url() }}/public/assets/js/facture.js"></script>
@endsection

</body>
</html>