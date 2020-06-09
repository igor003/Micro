
@extends('layouts.app')
@section('content')

  
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data_foto = <?php print_r(json_encode($data)); ?>;
        console.log(data);
       var data = new google.visualization.DataTable();
       data.addColumn('number','micrografia nmb');
       data.addColumn('number','time for executing min');
       data.addColumn({'type':'string','role':'tooltip','p': {'html': true}});
       data.addRows(data_foto);
        var options = {
            tooltip:{isHtml: true},
            bar: {groupWidth: "75%"},
            legend:'none',
            height: 400,
            opacity: 0.8,
            animation:{
                duration: 1000,
                easing: 'out',
            },
            hAxis: {
                gridlines: {
                count: 10,
                }
            },

            
  
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
                  
        chart.draw(data, options);
              function resize () {
    // change dimensions if necessary
    chart.draw(data , options);

}
if (window.addEventListener) {
    window.addEventListener('resize', resize);
}
else {
    window.attachEvent('onresize', resize);
}
        // chart.draw(data, options);
      

      }
</script>
 <div class="container">
    <div class="row">
        <div class="col-xs-10 text-center">
            
            <h1> {{$cur_date}}</h1>
        </div>
    </div>
        <div class="row">

            <div class="col-xs-10">
                <div id="columnchart_material"></div>
            </div>
            <div class="col-xs-2">
              
                <div class="form-group">
                       <label  for="datepicker_exec">
                                  Enter date 
                            </label>
                         <div class="form-group center">
                          
                            <input id="datepicker_exec" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date ">
                           
                        </div>   
                       <div class="form-group">
                            <button type="submit"  class="btn btn-primary"><a  href="/execut_time_report" style="text-decoration:none;color:white" id='exec_micro'>submit</a></button>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

