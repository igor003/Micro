
@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
           
            <div class="col-xs-12 ">
                <h4>Codice: <b>{{$cur_config[0]->codice->name}}</b> </h4>
                <h4>Components:<b> {{$cur_config[0]->components}}</b></h4>
                 <h4>Height:<b> {{$cur_config[0]->height}}</b></h4>


                
                
           
                
            </div>
        </div>
        <div class="row " id='content'>
       <div id="line_top_x"></div>
            
                                
                                        
                                   
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
        // hAxis: { minValue: 0, maxValue: 7 },
        // pointSize: 100,
        height: 500,
      lineWidth: 4,

      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>
@endsection