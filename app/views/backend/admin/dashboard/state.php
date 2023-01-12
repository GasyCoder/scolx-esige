 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

       var record={{ json_encode($user) }};
       console.log(record);

        var data = google.visualization.arrayToDataTable([
        data.addColumn('string', 'Source');
        data.addColumn('number', 'Total_Signup');
          for(var k in record){
            var v = record[k];
           
             data.addRow([k,v]);
          console.log(v);
          }

        var options = {
          title: 'Statistiques',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
<div id="piechart_3d" class="card min-w-0" style="width:830px; height: 500px;"></div>