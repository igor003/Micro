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
            <div class="col-sm-10 col-lg-offset-1 col-lg-3 ">
                <div class="input-group">
                    {{ csrf_field() }}
                    <input id="search_calibration" type="text" class="form-control" placeholder="Search codice">
                </div>
            </div>
            <div class=" col-sm-10 col-lg-offset-1 col-lg-3 ">
                <div class="input-group text-center">
                    {{ csrf_field() }}
                    <input id="search_machines" type="text" class="form-control" placeholder="Search machine">
                </div>
            </div>
             <div class="col-lg-offset-1 col-lg-3 col-sm-10">
                <div class="input-group">
                    {{ csrf_field() }}
                    <input id="search_miniaplicators" type="text" class="form-control" placeholder="Search mini">
                </div>
            </div>

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
                        <td>
                            Components
                        </td>
                        <td>
                            Connector
                        </td>
                        <td>
                            Machine
                        </td>
                        <td>
                            Miniaplicator
                        </td>
                       
                        <td>
                            Calibration up
                        </td>
                        <td>
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