@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
    	<div class="col-xs-4"></div>
    	<div class="col-xs-4" >
    		<form action="{{route('add_miniaplicator')}}" method="POST">
		        <div class="form-group">
	                <label for="mini">Minipalicator nmb</label>
	                <input type="text" name="miniaplicator_nmb" class="form-control" id="mini" aria-describedby="emailHelp" placeholder="Enter miniaplicator nmb">
            	</div>
            	<div class="form-group">
        	    <label for="connect">Select connector:</label>
	                <select name="connector" class="form-control" id="connect">
	                    <option  value="" selected></option>
	                    @foreach($connectors as $connector)
	                        <option value="{{$connector->id}}">
	                            {{$connector->name}}
	                        </option>
	                    @endforeach
	                </select>
            	</div>
            	<div class="form-group text-center">
            		<button id="submit_form" type="submit" class="btn btn-primary">Submit</button>
            	</div>
    	        {{ csrf_field() }}
    		</form>
    	</div>
    </div>
</div>

@endsection
