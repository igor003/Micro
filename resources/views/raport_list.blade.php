
@extends('layouts.app')
@section('content')


 <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <table id="raport_list" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Parts with microsection
                        </td>
                    </thead>
                    <tbody id="raport_content">
                        @foreach($parts_micro as $part)
                            <tr class='text-center'>
                                <td>
                                    {{$part}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xs-3">
                <p class="bg-success text-center">Data : {{$data_raport}}</p>
                <p class="bg-info text-center">Total parts : {{$parts}}</p>
                <p class="bg-info text-center">Parts with microsection : {{count($parts_micro)}}</p>
                <p class="bg-info text-center">Microsections efectuated : {{count($parts_efectuated)}}</p>

               <form method="POST" action="{{route('create_report')}}">

                        <input type="hidden" name="total_micr" value="{{count($parts_micro)}}" class="form-control" id="total_micr" aria-describedby="emailHelp">
                        <input type="hidden" name="efectuated_micr" value="{{count($parts_efectuated)}}" class="form-control" id="efectuated_micr" aria-describedby="emailHelp">
                        <input type="hidden" name="total_launch" value="{{$parts}}" class="form-control" id="total_launch" aria-describedby="emailHelp">
                        <input type="hidden" name="date" value="{{$data_raport}}" class="form-control" id="date" aria-describedby="emailHelp">
                        {{ csrf_field() }}
                    
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="col-xs-3">
                <table id="raport_list" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Microsections efectuated
                        </td>
                    </thead>
                    <tbody id="raport_content">
                        @foreach($parts_efectuated as $part_ef)
                            <tr class='text-center'>
                                <td>
                                    {{$part_ef}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table id="raport_list" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                           Missing microsections 
                        </td>
                    </thead>
                    <tbody id="raport_content">
                        @foreach($difference as $diff)
                            <tr class='text-center'>
                                <td>
                                    {{$diff}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
          
                
            </div>
            <div class="col-xs-3">
                <div id="piechart" style="width: 500px; height: 400px;"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Micro efectuate',     <?php echo count($parts_efectuated)?>],
          ['Micro neefectuate',      <?php echo count($parts_micro) - count($parts_efectuated)?>],

        ]);

        var options = {
          title: 'My Daily Micrografies',
          is3D: true,
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
@endsection
