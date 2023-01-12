  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      <?php 
      $payed       = Instance::where('payed', 1)->get();
      $nopay       = Instance::where('payed', 0)->get();
      ?>
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Payer', 'NonPayer'],

          ['Payé',        {{count($payed)}}],
          ['Non-Payé',     {{count($nopay)}}]

        ]);

        var options = {
          title: 'Statistiques de paiement',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
    @if( count($payed) > 0)
    <div id="piechart_3d" style="width: 800px; height: 400px;"></div>
    @endif