
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-8 col-lg-4">
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8  text-center">
                <h4>
                    Validations done
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="validation_table_done" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Date
                        </td>
                        <td class="text-center">
                            Miniaplicator nmb
                        </td>
                         <td class="text-center">
                            Connector
                        </td>
                        <td class="text-center">
                            Type validation
                        </td>
                        <td class="text-center">
                            Download
                        </td>
                    </thead>
                    <tbody id="table_validation_done">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 ">
            	<div class="form-group">
                    <label  for="datepicker_photo_from">
                              Enter date from  
                    </label>
                    <input id="date_validation" name='date_valid' type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date from">
                </div>
                <br>
				<div class="form-group">
                    <label for="mini">Miniaplicator</label>
                    <select name="minaplicator" class="form-control" id="mini">
                        <option  value="" selected></option>
                         @foreach($minis as $mini)
                            <option value="{{$mini->id}}">
                                {{$mini->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
