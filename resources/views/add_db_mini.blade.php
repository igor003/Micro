@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
    	<!-- <div class="col-xs-4"></div>
    	<div class="col-xs-4" >
    		<form action="" method="POST">
            	<div class="form-group">
        	    <label for="mini">Select mini:</label>
	                <select name="mini" class="form-control" id="mini">
	                    <option  value="" selected></option>
	                    @foreach($minis as $mini)
	                        <option value="{{$mini->id}}">
	                            {{$mini->name}}
	                        </option>
	                    @endforeach
	                </select>
            	</div>
            	<div class="form-group text-center">
            		<button id="submit_form" type="submit" class="btn btn-primary">Submit</button>
            	</div>
    	        {{ csrf_field() }}
    		</form> -->
    	<!-- </div> -->
    </div>
</div>

@endsection
