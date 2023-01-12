@extends('backend.main')
<?php $path = Session::get('language'); 
$control = Control::find(1);
?>
@section('title') {{ $title }}@stop
@section('content')
    <main class="workspace">
        <!-- Breadcrumb -->
        <section class="breadcrumb lg:flex items-start">
            <div class="p-8">
            <h3>Bilan des examens</h3>
            <ul>
                <li><a href="#no-link" class="link" data-target="[data-menu=ui]" data-toggle="tooltip-menu" data-tippy-content="UI">Résultats</a></li>
                <li class="divider la la-arrow-right"></li>
                <li>{{$title}}</li>
            </ul>
            </div>
        </section>
         <!-- Actions -->
        <div class="breadcrumb breadcrumb_alt p-3 flex flex-wrap gap-2">
            <a href="/admin/resultats_examen_bilan/class/etudiants" class="btn btn_outlined btn_primary">
                <span class="la la-undo text-xl leading-none ltr:mr-1 rtl:ml-1"></span>
                Retour
            </a>
            <div class="flex flex-wrap gap-2 ltr:ml-auto rtl:mr-auto">
            <button class="btn btn_outlined btn_success">
                    Année Universitaire: {{$year->yearsUniv}} 
            </button>    
            </div>
        </div> 
      
@include('backend.admin.administration.Pay.return')
            <div class="grid lg:grid-cols-2 gap-5">
            <div class="card p-5 flex flex-col mt-5">
                <h3>Statistique des Admis</h3>
                <div class="flex flex-col ltr:mr-2 rtl:ml-2 ltr:ml-auto rtl:mr-auto badge badge_success font-bold">Total admis: {{count($bilanAdmis)}}</div>
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Classes</th>
                            <th class="" align="center">Admis</th>
                            <th class="" align="center">Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <?php
                            $Etudiants = Student::where('class_id', $class->id)
                                                  ->where('yearsUniv', $year->yearsUniv)
                                                  ->count();

                            $Lesadmis = Bilan::where('class_id', $class->id)
                                            ->where('admis', 1)
                                            ->where('moyenne', '>=', 10)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count();                           
                        ?>
                        <tr>
                            <td>{{$class->name}}</td>
                            <td class="" align="center">
                                @if($Lesadmis > 0)
                                <div class="badge badge_success font-bold">{{$Lesadmis}}</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0</div>
                                @endif
                            </td>
                            
                            <td class="" align="center">
                                @if($Lesadmis > 0)
                                <div class="badge badge_primary font-bold">{{number_format($Lesadmis*100/$Etudiants, 1, ',', '')}}%</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0%</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr class="border-dashed mt-3">
                <table class="table table_list mt-3 w-full">
                    <thead>
                        <tr>
                            <th class="ltr:text-left rtl:text-right">Classes</th>
                            <th class="" align="center">Très-Bien</th>
                            <th class="" align="center">Bien</th>
                            <th class="" align="center">Assez-Bien</th>
                            <th class="" align="center">Passable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <?php

                            $passable = Bilan::where('class_id', $class->id)
                                            ->where('admis', 1)
                                            ->where('moyenne', '>=', 10)
                                            ->where('moyenne', '<=', 11.99)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count();

                            $assezBien = Bilan::where('class_id', $class->id)
                                            ->where('admis', 1)
                                            ->where('moyenne', '>=', 12)
                                            ->where('moyenne', '<=', 13.99)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count(); 

                            $Bien = Bilan::where('class_id', $class->id)
                                            ->where('admis', 1)
                                            ->where('moyenne', '>=', 14)
                                            ->where('moyenne', '<=', 15.99)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count(); 

                            $TresBien = Bilan::where('class_id', $class->id)
                                            ->where('admis', 1)
                                            ->where('moyenne', '>=', 16)
                                            ->where('yearsUniv', $year->yearsUniv)
                                            ->count();                                              
                        ?>
                        <tr>
                            <td>{{$class->name}}</td>
                            <!--Mention très-bien-->
                            <td class="" align="center">
                                @if($TresBien > 0)
                                <div class="badge badge_success font-bold">{{$TresBien}}</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0</div>
                                @endif
                            </td>
                            <!--Mention bien-->
                            <td class="" align="center">
                                @if($Bien > 0)
                                <div class="badge badge_primary font-bold">{{$Bien}}</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0</div>
                                @endif
                            </td>
                            <!--Mention assez-bien-->
                            <td class="" align="center">
                                @if($assezBien > 0)
                                <div class="badge badge_warning font-bold" style="color:#333">{{$assezBien}}</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0</div>
                                @endif
                            </td>
                            <!--Mention passable-->
                            <td class="" align="center">
                                @if($passable > 0)
                                <div class="badge badge_info font-bold">{{$passable}}</div>
                                @else 
                                <div class="badge badge_outlined badge_secondary">0</div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> 
             <!-- Bar With Shadow -->
            <div class="breadcrumb breadcrumb_alt p-5 min-w-0 mt-5">
                <h3>Diagramme</h3>
                <div class="mt-5 min-w-4">
                    <!--Div that will hold the pie chart-->
                        <div id="chart_div"></div>
                </div>
            </div>
        </div>    
@include('backend.pages.footer')
@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.

      <?php 
      $yearCurrent = Year::where('status', 1)->first();
      $yearOld     = Year::where('status', 0)->first();

      //Bilan 
      $AdmisCurrent    = Bilan::where('admis', 1)
                        ->where('yearsUniv', $yearCurrent->yearsUniv)
                        ->count();
      $AdmisOld    = Bilan::where('admis', 1)
                        ->where('yearsUniv', $yearOld->yearsUniv)
                        ->count();                  
      ?>

      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', '#année actuel');
        
        //This is where you will need to pass you SQL data to JavaScript, I have not included this information at present
        data.addRows([
          ['{{$yearCurrent->yearsUniv}}' ,{{$AdmisCurrent}}],
          ['{{$yearOld->yearsUniv}}', {{$AdmisOld}}],
          //['01/04/17',9],
          //['01/05/17',6]
        ]);

        // Set chart options
        var options = {'title':'Diagramme des résultats par année',
                       'width':800,
                       'height':400};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
@endsection 
</main>
@stop