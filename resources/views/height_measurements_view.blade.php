
@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">   
        <div class="col-xs-6 ">
            <h4>Codice: <b>{{$cur_config[0]->codice->name}}</b> </h4>
            <h4>Components:<b> {{$cur_config[0]->components}}</b></h4>
            <h4>Height:<b> {{$cur_config[0]->height}}</b></h4>     
        </div>
        <div class="col-xs-6 ">
            <h4>CP: <b>{{$capability['cp']}}</b> </h4>
            <h4>CPK: <b>{{$capability['cpk']}}</b></h4>
             
        </div>
    </div>
    <div class="row " id='content'>
        <div class="col-xs-8">
            <div id="line_top_x"></div>    
        </div>
        <div class="col-xs-4">
            <div id="chart_div"></div>   
        </div>
                                                       
    </div>
    <br>

    Max date:
    <?php
    echo (substr(max($dates), 0, 10));
    ?>
    <br>
    Min date:
    <?php
     echo (substr(min($dates), 0, 10));
    ?>
    
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">1</th>
                    <th scope="col">2</th>
                    <th scope="col">3</th>
                    <th scope="col">4</th>
                    <th scope="col">5</th>
                    <th scope="col">6</th>
                    <th scope="col">7</th>
                    <th scope="col">8</th>
                    <th scope="col">9</th>
                    <th scope="col">10</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php 
                    $i = 0;
                    foreach ($heights as $value) {
                      if ($i % 10 === 0) {
                            echo '</tr><tr>';
                        }

                 
                      echo "<td>" . str_replace('.',',',$value['height'] ). "</td>";
                      $i++;
                    }
                ?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'proba');
      data.addColumn('number', 'Measured value');
      data.addColumn('number', 'Minimum limit');
      data.addColumn('number', 'Maximum limit');


      data.addRows(<?php print_r(json_encode($measurements)); ?>);

      var options = {
       
        height: 300,
        lineWidth: 2,

      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>

 
  <script type="text/javascript">
      google.charts.load('visualization','1',{'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data_foto = <?php print_r(json_encode($values)); ?>;
        var data = google.visualization.arrayToDataTable(data_foto);
        var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }
                       ]);
        var options = {
            seriesType: 'bars',
            
            bar: {groupWidth: "50%"},
            legend: { position: "none" },
            height: 300,
            opacity: 0.8,
        };


        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            
        chart.draw(view, options);
      }
</script>

<script>
    
    
</script>
@endsection