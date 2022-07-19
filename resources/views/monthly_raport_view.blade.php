
@extends('layouts.app')
@section('content')

  
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data_foto = <?php print_r(json_encode($fotos)); ?>;
        console.log(data_foto);
        var data = google.visualization.arrayToDataTable(data_foto);
        var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }
                       ]);
        var options = {
          
            bar: {groupWidth: "75%"},
            legend: { position: "none" },
            height: 400,
            opacity: 0.8,
            animation:{
                duration: 1000,
                easing: 'out',
            },
            hAxis : {
                      
                        textPosition : "out",
                        showEveryText : 1,
                        viewWindow : {
                            min : 0
                        },
                        textStyle:{
                            color: 'black',
                            fontSize: 10,
                        },
                        slantedText : true
                    },
            

        };


        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material2'));
            
        chart.draw(view, options);
      }
</script>

<!--  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_material2"));
      chart.draw(view, options);
  }
  </script -->
 <div class="container">
    <div class="row">
        <div class="col-xs-10 text-center">
            
            <h1>{{$cur_year}} {{$cur_month}}</h1>
        </div>
    </div>
        <div class="row">

            <div class="col-xs-10">
                <div id="columnchart_material2"></div>
            </div>
            <div class="col-xs-2">
              
                <div class="form-group">
                      <label for="raport_monthly_year">Select year</label>
                         <div class="form-group center">
                            <select name="month" class="form-control" id="raport_monthly_year">
                                <option  value="" selected></option>
                                @foreach($years as $year)
                                    <option value="{{$year}}">
                                        {{$year}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    <label for="raport_monthly">Select Month</label>
                        <div class="form-group center">
                            <select name="month" class="form-control" id="raport_monthly">
                                <option  value="" selected></option>
                                @foreach($months as $key=>$month)
                                    <option value="{{$key + 1}}">
                                        {{$month}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                      
                        
                       <div class="form-group">
                            <button type="submit"  class="btn btn-primary"><a  href="/monthly_report" style="text-decoration:none;color:white" id='month_micro'>submit</a></button>
                        </div>
                </div>
            </div>
            <!-- <div class=" col-xs-4 ">
                <form action="{{route('generate_raport')}}" method="POST" enctype="multipart/form-data">
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
            </div> -->
        </div>
    </div>
@endsection

