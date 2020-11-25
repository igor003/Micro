
@extends('layouts.app')
@section('content')

<script>

    var result1  = <?php print_r(json_encode($jsArray1)); ?>;
       console.log(result1);
      var i = 0;
    for (i; i < result1.length; i++){
        result1[i][1] = new Date(result1[i][1]);
        result1[i][2] = new Date(result1[i][2]);
        
    }
   
google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var container = document.getElementById('curve_chart');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Operatpr' });
    dataTable.addColumn({ type: 'datetime', id: 'Start' });
    dataTable.addColumn({type: 'datetime', id: 'End' });
    dataTable.addColumn({'type': 'string', 'role': 'tooltip', 'p': {html: true}});
    dataTable.addRows(result1);

     
    var options = {
        colors: ['#3471EB', 'green', 'gray'],
        height: 400,
     
        tooltip: {
            isHtml: true
        }

    };

    chart.draw(dataTable, options);
    function myHandler(e){
        if(e.row != null){
            $(".google-visualization-tooltip").html(dataTable.getValue(e.row,3)).css({width:"auto",height:"auto"});
        }        
    }
    
    google.visualization.events.addListener(chart, 'onmouseover', myHandler);
  }
//     var i = 0;
//     for (i; i < result1.length; i++){
//         result1[i][0] = new Date(result1[i][0]);
        
//     }
//     // var cnt = 0;
//     // for (cnt; cnt < result2.length; cnt++){
//     //   result2[cnt][0] = new Date(result2[cnt][0]);
//     // }
//     google.charts.setOnLoadCallback(drawChart);

//           function drawChart() {
//         var data = new google.visualization.DataTable();
//           data.addColumn('datetime', 'start');
//             data.addColumn('number', 'micro done');
//          data.addColumn('number', 'micro start');   
          
        
//             data.addRows(result1);

//         // var data1 = new google.visualization.DataTable();
//         //     data1.addColumn('datetime', 'end');
//         //     data1.addColumn('number', 'micrografia nmb');
           
//         //     data1.addRows(result2);

//         // var joinedData = google.visualization.data.join(data, data1, 'full', [[0, 0]], [1], [1]);
//         // console.log(joinedData);

//         var options = {
//             title: 'SAMMY Micrography',
//             curveType: 'function',
//             height: 400,
//             theme: 'material',
//             selectionMode: 'single',
//             aggregationTarget: 'none',
//             focusTarget: "category",
//             curveType: 'function',
//             tooltip: {"trigger": 'both'},
//             interpolateNulls: true,
          
//             legend: { 
//                 position: 'none',
//             },
//             hAxis: {
//                 title: 'Time',
//                 textStyle : {
//                     fontSize: 17 
//                 }
//             },
//             vAxis: {
//                 title: 'nmb of micrography',
//                 textStyle : {
//                   fontSize: 17 
//                 }
//             },
//             pointsVisible: true,
//             animation:{
//                 duration: 1700,
//                 easing: 'inAndOut',
//                 startup: true
//             },
//             explorer : {
//                 axis: 'horizontal',
//                 actions: ['dragToZoom', 'rightClickToReset']
//             },
//             crosshair: { 
//                 trigger: "both",
//                 orientation: 'vertical' 
//             } 
//         };

//         var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

     
// chart.draw(data , options);
 
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
      

</script>
 <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            

        </div>
    </div>
        <div class="row">

            <div class="col-xs-10">
                <div id="curve_chart"></div>
            </div>
            <div class="col-xs-2">
               
                <div class="form-group">
                    <label class=" project_label form-check-label" for="datepicker_photo_from">
                                  Enter date from  
                    </label>
                    <input id="datepicker_photo" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date from">
                </div>
                 <div class="form-group">
                    <button type="submit"  class="btn btn-primary"><a  href="/raport_view" style="text-decoration:none;color:white" id='date_micro'>submit</a></button>
                 </div>
               
            </div>
            <div class=" col-xs-4 ">
                <form action="{{route('generate_raport_aggraf')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                         <label class=" project_label form-check-label" for="file">
                                      Select Excell file
                        </label>
                        <input type="file" class="form-control" id="file" name="document">
                    
                    <div class="form-group">
                        <label class=" project_label form-check-label" for="datepicker_raport">
                                      Enter date for raport
                        </label>
                        <input name='data_raport' id="datepicker_raport" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date">
                    </div>
                    
                        <input type="submit" class="btn btn-primary" name='submit_excell' value="Upload Excell">
                    
                </form>
            </div>
        </div>
    </div>
@endsection

