<?php 
$path = Session::get('language');
$control = Control::find(1); 
?> 
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title> Print</title>
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

    {{ HTML::style('public/assets/css/facture.css') }}
    {{ HTML::style('public/assets/css/font_fac.css') }}
  <style>
     @media print {
      #sidebar-menu, #desktop-menu, footer, #btn-invoice {
        display: none;
        page-break-after: always;
      }
      .main {
          margin-top:2px;
          padding-top: 0;
          min-width: 100%;
      }
      .bod{
        container xl:max-w-7xl;
      }
      .thx{
        font-size:0.7rem;
        position: inline-block;
      }
      h{
        font-size:0.5rem;
      }
      .ab{
        color:red;
        text-decoration: underline;
      }
      .pr{
        color:green;
        text-decoration: underline;
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
        size: 21cm 29.7cm; margin: 3cm
        width: 5rem;
        card: nonre;
        line-height: 120%; text-align: justify; background: transparent
    }
  </style>    
</head>
<body class="font-sans text-base font-normal">
@include('backend.admin.administration.Pay.ecolage.fac_banner')
@include('backend.timeAgo')
      <main class="main pt-30 -mt-2">
      <div class="relative py-12">
      <div class="bod">
             <div class="flex-shrink max-w-full px-4 w-full mb-6">
              <div class="p-6 bg-white">
            <div id="btn-invoice" class="flex flex-wrap flex-row -mx-6 justify-center">
              <button type="button" id="btn-invoice" onclick="window.print();" class="py-2 px-4 inline-block text-center mb-3 rounded leading-5 text-gray-100 bg-indigo-500 border border-indigo-500 hover:text-white hover:bg-indigo-600 hover:ring-0 hover:border-indigo-600 focus:bg-indigo-600 focus:border-indigo-600 focus:outline-none focus:ring-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2 inline-block bi bi-printer" viewbox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
              </svg>Imprimer</button>
            </div>
                <div class="flex justify-between items-center border-b border-gray-200">
                  <div class="flex flex-col">
                    <div class="text-3xl font-bold mb-1">
                      <img class="inline-block w-12 h-auto mr-2 shadow-xl rounded-xl" src="{{ url() }}/public/uploads/logo/{{$control->logo}}">ESIGE
                    </div>
                    <p class="text-sm"><b class="text-red-600">É</b>cole <b class="text-red-600">S</b>upérieure d'<b class="text-red-600">I</b>nformatique<br> et de <b class="text-red-600">G</b>estion des <b class="text-red-600">E</b>ntreprises<br>Mahajanga, Madagascar</p>
                  </div>
                   {{ QrCode::encoding("UTF-8")->size(130)->generate($control->school_name.'Enseignement Supérieur|' .$control->email);}}
                </div>
                <div class="text-lg font-bold flex items-center justify-center mt-3">
                  <h6 class="">Année Universitaire: {{$year->yearsUniv}}<br>
                  <center class="underline text-sm">Listes des absents/présents</center></h6>
                </div>
                <center>
                  <p><?php $students = Student::where('class_id', $class->id)->count();?>
                    Eff Total: <b>{{$students}}</b>
                  </p>
                </center>
				<table class="table-sm table-bordered w-full text-left text-gray-900 mt-5">
				  <thead>
            <tr class="text-xl"> 
             <th colspan="8" style="text-align:center;">Du: <code> {{ \Carbon\Carbon::parse($datyPrint->dateStart)->format('d M')}} au {{ \Carbon\Carbon::parse($datyPrint->dateEnd)->format('d M Y')}} </code><br>
                <small><u style="color:#16A34A">Présents</u> : <b>{{$presents}}</b></small> | <small><u style="color:#DC2626">Absents</u> : <b>{{$absents}}</b></small>
             </th>
            </tr>
				    <tr class="bg-gray-50 text-gray-800">
              <th class="ltr:text-left rtl:text-right" style="text-align:center;">#</th>
              <th width="150" class="ltr:text-left rtl:text-right" style="text-align:center;">Photo</th>
				      <th>Etudiants</th>
              <th width="110" class="text-center">Classes</th>
              <th width="110" class="text-center">Parcours</th>
				      <th width="210">Matières</th>
              <th width="150" class="text-center">Heurs</th>
				      <th width="150" class="text-center">Statuts</th>
				    </tr>
				  </thead>
				  <tbody>
				  	@foreach($absencePrint as $key => $print)
            <?php 
             $student = Student::where('matricule', $print->id_student)->first();
             $ec = EC::where('id', $print->element_id)->first();  
            ?>    
				    <tr class="text-gray-800">
              <td class="text-center">{{$key+1}}</td>
              <td>
              <center>
              <div class="rounded-full shadow-xl w-12 h-12 max-w-full bg-gray-300 border-2 border-gray-200 transform hover:-translate-y-1">
                 @if(!empty($student->image))
                  <?php 
                  echo HTML::image('uploads/profiles/students/'.$student->image.'', '', ['class'=>'', 'width'=>'','height'=>'']) 
                  ?>
                  @elseif($student->sexe == 1)
                  {{ HTML::image('public/assets/avatar/man.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                   @else {{ HTML::image('public/assets/avatar/woman.png', '', ['class'=>'', 'width'=>'','height'=>'']) }}
                  @endif
              </div>
              </center>
              </td>
				      <td class="h">{{$student->fname}} {{$student->lname}}</td>
				      <td class="text-center">{{$student->niveau->short}} @if($student->grade == 'AL') mixte @endif</td>
              <td class="text-center">{{$student->parcour->abr}}</td>
				      <td>{{$ec->name}}</td>
              <td class="text-center h">
                {{ \Carbon\Carbon::parse($print->timeStart)->format('H:i')}} à 
                {{ \Carbon\Carbon::parse($print->timeEnd)->format('H:i')}}
              </td>
				      @if($print->status == 0)
              <td class="text-center"><span class="inline-block leading-none text-center py-1 px-2 bg-red-700 text-gray-100 font-bold rounded-xl ab" style="font-size:.75em;">@if($student->sexe == 1)Absent @else Absente @endif</span></td>
              @else
              <td class="text-center"><span class="inline-block leading-none text-center py-1 px-2 bg-green-700 text-gray-100 font-bold rounded-xl pr" style="font-size:.75em;">@if($student->sexe == 1)Présent @else Présente @endif</span></td>
              @endif
				    </tr>
				    @endforeach
				  </tbody>
				</table>          
              </div>
            </div>
          </div>
        </div>
      </main>
<script src="{{ url() }}/public/assets/js/facture.js"></script>
</body>
</html>