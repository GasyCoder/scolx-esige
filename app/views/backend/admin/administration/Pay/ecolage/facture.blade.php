<?php 
$path = Session::get('language');
$control = Control::find(1); 
?> 
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title> Facture N°-{{$allFacture->payment_index}}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    {{ HTML::style('public/assets/print/css/invoice.css') }}
    {{ HTML::style('public/assets/css/paper.css') }}
    <style>
        @media print {
          #sidebar-menu, #desktop-menu, footer, #btn-invoice {
            display: none;
          }
        .img {
        width:35rem;
        height:4rem;
        left: 0;
        right: 0;
  }  
      }
        @page { size: A5 }
    
    .img {
        width:35rem;
        height:4rem;
        left: 0;
        right: 0;
  }  
    </style>
  </head>
  <body class="A5"> 
    <section class="wrapper-invoice ">
      <!-- switch mode rtl by adding class rtl on invoice class -->
      <div class="invoice">
    <div class="" id="btn-invoice"  style="text-align:center;">
         <button type="button" onclick="window.print();" class="">
              <i class="la la-print"></i>  Imprimer
        </button>
    </div>  
        <div class="invoice-information">
          <p><b>Facture #</b> : {{$allFacture->payment_index}}</p>
          <p><b>Date </b>: {{ \Carbon\Carbon::parse($allFacture->created_at)->format('d/m/y')}} à Mahajanga</p>
          <p><b>Type paiement</b> : @if($allFacture->status = 1) Espèce @endif</p>
        </div>
        <!-- logo brand invoice -->
        <div class="invoice-logo-brand">  
          <img src="{{ url() }}/public/uploads/logo/{{$control->logo}}">
        </div>
        <!-- invoice head -->
        <div class="invoice-head">
          <div class="head client-info">
            <p style="font-size:0.7rem;"><b class="text-red-600">É</b>cole <b class="text-red-600">S</b>upérieure d'<b class="text-red-600">I</b>nformatique<br> et de <b class="text-red-600">G</b>estion des <b class="text-red-600">E</b>ntreprises<br>Mahajanga, Madagascar</p>
          </div>
          <div class="head client-data">
            <p><strong class="text-lg"><u>Doit</u>:</strong></p>
            <p>@if($allFacture->etudiant->sexe == 1)Mr: @else Mlle/Mme:@endif {{$allFacture->etudiant->fname}} {{$allFacture->etudiant->lname}}</p>
            <p>Niveau: {{$allFacture->niveau->short}} @if($allFacture->etudiant->grade == 'AL')Auditeur Libre @endif</p>
            <p>Parcours: {{$allFacture->parcour->abr}}</p>
          </div>
        </div>
        <!-- invoice body-->
        <div class="invoice-body">
          <table class="table">
            <thead>
              <tr>
                <th>Motif</th>
                @if($allFacture->nbreMois >= 1)
                <th width="80">Nbre mois</th>
                @else<th style="color:#000" width="30">Qte</th>@endif
                <th width="150">Prix U</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                    @if($allFacture->title == 'Ecolage'){{$allFacture->title}} mois de ({{$allFacture->mois}})
                    @else 
                    {{$allFacture->title}} 
                    @endif
                </td>
                 @if($allFacture->nbreMois >= 1)
                 <td align="center">{{$qte}}</td>
                 @else 
                 <td style="color:#000">1</td> 
                 @endif

                @if($allFacture->title == 'Ecolage')
                <td class="text-center">             
                  {{$pricU.''.$control->payment_unit }}
                </td>
                @else
                <td class="text-center">             
                  {{$droitU.''.$control->payment_unit }}
                </td>
                @endif

              </tr>
            </tbody>
          </table>
          <div class="flex-table">
            <div class="flex-column"></div>
            <div class="flex-column">
              <table class="table-subtotal">
                <tbody>
                  <tr>
                    <td>Sous-total</td>
                    @if($allFacture->nbreMois >= 1)<td>{{$subtotal1.''.$control->payment_unit}}</td> @else <td>{{$droitU.''.$control->payment_unit }}</td> @endif
                  </tr>
                  @if($control->activeRemise == 1)
                  <tr>
                    <td>Remise <small>(-{{$control->remise}}%)</small></td>
                    <td>-{{ $remise .''.$control->payment_unit }}</td>
                  </tr>
                  @endif
                  @if($control->activeTax == 1)
                  <tr>
                    <td>Taxe <small>({{$control->payment_tax}}%)</small></td>
                    <td>{{ $tax .''.$control->payment_unit }}</td>
                  </tr>
                  @endif
                  <tr>
                    <td>Coût hors taxe</td>
                    <td>{{$allFacture->montant.''.$control->payment_unit }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- invoice total  -->
          <div class="invoice-total-amount">
            <p>Total TTC : 
                @if($control->activeTax == 1) {{ ($allFacture->montant)+($tax)-($remise).''.$control->payment_unit }}
                @elseif($control->activeRemise == 1)
                {{ ($allFacture->montant)+($tax)-($remise).''.$control->payment_unit }}
                @else
                {{($allFacture->montant).''.$control->payment_unit}}
                @endif <br><br>
            </p>
          </div>
          <div style="text-align:right;font-size: 1.2vh;">
            <span>Arrêté la somme de</span>:
                <b> <?php $t = new NumberFormatter("fr-FR", NumberFormatter::SPELLOUT); echo $t->format(($allFacture->montant)+($tax)-($remise)). ' ' .'Ariary';?></b>
            </div>
{{ QrCode::encoding("UTF-8")->size(100)->generate(
'Facture N°:'.         ' ' .$allFacture->payment_index. ' | ' 
.'Date:'.              ' ' .\Carbon\Carbon::parse($allFacture->created_at)->format('d/m/y').           
                    ' | ' 
.'Niveau:'.            ''.$allFacture->niveau->short.'-' .$allFacture->parcour->abr.
' | '  .'Université:'.      ' ' .'ESIGE MAHAJANGA');}}
        </div>
        <!-- invoice footer -->
        <div class="invoice-footer">
          <p>Signé par: <strong>{{$allFacture->user->fname}}</strong>
        </div>
      </div>
    </section>
    <div class="copyright">
      <p>Created by ❤ Gasy Coder</p>
    </div>
  </body>
</html>
