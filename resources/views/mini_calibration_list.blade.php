@extends('layouts.app')

@section('content')
    <div class="container">
         <div class="row">
            <div class="col-md-12  text-center">
                <h4>
                    Mini calibration
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-4 text-center">
               
                    {{ csrf_field() }}
                    <label for="search_calibration  ">Codice:</label>
                    <input id="search_calibration" type="text" class="form-control" placeholder="Search codice">
               
            </div>
            <div class=" col-xs-12  col-lg-4 text-center ">
                
                    {{ csrf_field() }}
                    <label for="search_machines">Preseta:</label>
                    <input id="search_machines" type="text" class="form-control" placeholder="Search machine">
              
            </div>
             <div class="col-xs-12 col-lg-4 text-center ">
                
                    {{ csrf_field() }}
                    <label for="search_miniaplicators ">Mini:</label>
                    <input id="search_miniaplicators" type="text" class="form-control" placeholder="Search mini">
             
            </div>

            <br>
        </div>
       <div class="row">    
                <br>    

       </div>
       
        <div class="row">
            <div class=" col-md-offset-1 col-md-10">
                <table id="calibration" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Codice
                        </td>
                        <td class="text-center">
                            Components
                        </td>
                        <td class="text-center">
                            Connector
                        </td>
                        <td class="text-center">
                            Machine
                        </td>
                        <td class="text-center">
                            Miniaplicator
                        </td>
                       
                        <td class="text-center">
                            Calibration up
                        </td>
                        <td class="text-center">
                            Calibration down
                        </td>
                        @if(Auth::user()->status == 'admin')
                            <td class="text-center">
                                Update
                            </td>
                            <td class="text-center">
                                Delete
                            </td>
                        @endif
                    </thead>
                    <tbody id="calibrations">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4">

            </div>
        </div>
    </div>
    <script>

    </script>
@endsection