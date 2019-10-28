@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-2 text-center ">
                <a calss='' href="">
                    <button class="btn btn-success">
                        <h5>Validations</h5>
                    </button>
                </a>
            </div>
            <div class="col-lg-offset-4 col-lg-4">
                <div class="input-group">
                    {{ csrf_field() }}
                    <input id="search_miniaplicator" type="text" class="form-control" placeholder="Search codice">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                <h4>
                    Miniaplciators
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
                <table id="miniaplicators_table" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center">
                                Number
                            </td>
                            <td class="text-center">
                                Update
                            </td>
                            <td class="text-center">
                                Delete
                            </td>
                        </tr>
                    </thead>
                    <tbody id="table_miniaplicators">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 ">
            	<select name="connector1" class="form-control" id="connector1">
	                    <option  value="" selected></option>
	                     @foreach($connectors as $connector)
	                        <option value="{{$connector->id}}">
	                            {{$connector->name}}
	                        </option>
	                    @endforeach
	                </select>
                <!-- @foreach($connectors as $connector)
                    <input class="form-check-input" type="checkbox" value="{{$connector->id}}" id="connector">
                    <label class=" project_label form-check-label" for="connector">
                        {{$connector->name}}
                    </label>
                    <br>
                @endforeach -->
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection