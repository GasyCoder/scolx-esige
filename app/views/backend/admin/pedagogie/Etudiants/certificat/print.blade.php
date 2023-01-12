<?php 
$path = Session::get('language');
$control = Control::find(1); 
$domaine = Domaine::where('parcour_id', $certifi->parcour_id)
                  ->first();
$mention = Mention::where('domaine_id', $domaine->id)
                  ->first();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Imprimer | Certificat de Scolarité</title>
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
   {{ HTML::style('public/assets/css/print.css') }}

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
        size: 21cm 29.9cm; margin: 1cm;
        margin-top: 5px;
        width: 5rem;
        card: nonre;
        line-height: 120%; text-align: justify; background: transparent
    }
    
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #fff;
   color: #000;
   text-align: center;
}
</style>
</head>
<body>
  <div data-server-rendered="true" id="app">
    <div class="theme-container no-sidebar">
      <header class="navbar" id="btn-invoice">
      <a class="home-link router-link-active" href="/admin"><span class="site-name">SCOLX</span></a>
        <div class="links">
          <nav class="nav-links can-hide">
            <div class="nav-item">
              <button type="button" id="btn-invoice" onclick="window.print();" class="nav-link ltr:ml-5 rtl:mr-5" style="color:blue"><span class="la la-print text-xl"></span> Imprimer</button>
            </div>            
          </nav>
        </div>
      </header>

    <main class="page">
    <div class="theme-default-content content__default" style="border: 1px #f9f9f9 dotted;">
    <center> 
    <img src="{{url()}}/public/assets/images/tete.png">
    <hr>
    <h1 id="license"><u>CERTIFICAT DE SCOLARITE</u></h1>
    </center>
          <p>Je sousigné, Monsieur KARIM Ikbalhoussen, Le Directeur de l'Ecole Supérieur d'Informatique et de la Gestion des Entreprises, certifie que l'étudiant(e) :</p>
          <center><h3>{{$certifi->std->fname.' '.$certifi->std->lname}}</h3></center> 
          <p>Né(e) le {{$certifi->std->birth}} à {{$certifi->std->birthLocation}}
            <br>
          Demeurant à {{$certifi->std->address}}<br>
          Fils/Fille de : {{$certifi->std->papa}}<br> Et de : {{$certifi->std->mama}}
          </p>
          <p>Est inscrit(e) en <b>{{$certifi->niveau->name}}</b> de « <b>{{$certifi->niveau->note}}</b> », domaine « <b>{{$domaine->name}} </b>», mention « <b>{{$mention->name}} </b>», parcours « <b>{{$certifi->parcour->name}}</b> » pour l'année universitaire <b>{{$years->yearsUniv}}.</b>
          </p>
          <p>En foi de quoi, le présent certificat lui est délivré {{$certifi->motif}}.</p>
          <hr>
          <p style="margin-left:20rem">
          Fait à Mahajanga, le_______________ 
          </p>
          <p style="margin-right:20rem;">
          {{ QrCode::encoding("UTF-8")->size(130)->generate(
          'Certificat de Scolarité'. ' | '
          .'Référence:'.  ' ' .$certifi->ref.        ' | '
          .'Nom:'.        ' ' .$certifi->std->fname.  ' | ' 
          .'Prenom:'.     ' ' .$certifi->std->lname.   ' | ' 
          .'Classe:'.     ' ' .$certifi->niveau->short. '-' .$certifi->parcour->abr. ' | ' 
          .'Promotion:'.  ' ' .$certifi->std->promo.   ' | ' 
          .'Université:'. ' ' .'ESIGE MAHAJANGA');
          }}
          </p>
      		<br><br><br><br><br>
      		<div class="footer">
              <p> <small class="footer_tb">
              <small class="text-sm">
              <i>N.B: Certificat délivré en un seul exemplaire. Bien voulir faire une copie en cas de besoin.</i>
              </small>  
              <hr class="border-dashed">  
              B.P: 448 Tsararano Ambony, Mahajanga-401, Madagascar <br>
              Tél: 020 62 925 | +261 34 11 215 51 | +261 32 04 582 81 <br>
              Email: esige2003@yahoo.com |
              Web: www.esige.mg
            </small></p>
            </div>	
          <!--<hr>
          <small style="font-size:0.6rem;color:#c3c3c3">Powered by GasyCoder</small>-->
        </div>
      </main>
    </div>
    <div class="global-ui"></div>
  </div>
  @section('js')
  <script defer src="{{ url() }}/public/assets/js/facture.js"></script>
  @endsection
</body>
</html>