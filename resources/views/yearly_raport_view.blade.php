
@extends('layouts.app')
@section('content')

  
<script type="text/javascript">
      //google.charts.load('current', {'packages':['bar']});
      //google.charts.setOnLoadCallback(drawChart);

      //function drawChart() {
     
        //console.log(data_foto);
      // var data = google.visualization.arrayToDataTable(data_foto);


       // var options = {
          
           // bar: {groupWidth: "75%"},
           // legend: { position: "none" },
          // height: 400,
          //  opacity: 0.8,
           //  vAxis: {format: 'decimal'},
           // animation:{
            //    duration: 1000,
           //     easing: 'out',
    //  },
            

       // };

      //  var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));
                  
      //  chart.draw(data, google.charts.Bar.convertOptions(options));
      

           google.charts.load('current','1', {'packages':['corechart']});

           google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data_foto = <?php print_r( json_encode($fotos, false))?>;
            var data = new google.visualization.DataTable();
            data.addColumn('string',' month');
            data.addColumn({type:'string', role:'annotation'});
            data.addColumn('number','number of micro');
          
            data.addRows(Object.values(data_foto));
            var options ={
                annotations: {
                    alwaysOutside: true,
                },
                bar: {groupWidth: "75%"},
                legend:'none',
                chartArea: {
                    width: '90%'
                },
                height: 400,
                opacity: 0.8,
                animation:{
                    duration: 10000,
                    easing: 'out',
                },
                 vAxis: {  
                    viewWindow: { max: 1800, min:0 },
                     gridlines: {
                        count: 500,
                    }
                  
                }  ,
                hAxis: {
                    gridlines: {
                        count: 500,
                    }
                },
            }

            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material1'));
             
            chart.draw(data, options);
          }
         
        
</script>

 <div class="container">
    <div class="row">
        <div class="col-xs-10 text-center">
            
            <h1>{{$cur_year}} </h1> 
            <h3>Efectuated:{{$summ_micros}} micros</h3>
            <h3>Average time:{{$average_time}}</h3>
          
        </div>
    </div>
        <div class="row">

            <div class="col-xs-10">
                <div id="columnchart_material1"></div>
            </div>
            <div class="col-xs-2">
              
                <div class="form-group">
                      <label for="raport_monthly_year">Select year</label>
                         <div class="form-group center">
                            <select name="year" class="form-control" id="raport_yearly">
                                <option  value="" selected></option>
                                @foreach($years as $year)
                                    <option value="{{$year}}">
                                        {{$year}}
                                    </option>
                                @endforeach
                            </select>
                        </div>   
                       <div class="form-group">
                            <button type="submit"  class="btn btn-primary"><a  href="/yearly_report" style="text-decoration:none;color:white" id='year_micro'>submit</a></button>
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

