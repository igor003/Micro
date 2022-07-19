
@extends('layouts.app')
@section('content')
 <div class="container">
        <div class="row">

            <div class="col-xs-4"></div>
            <div class=" col-xs-4 ">
                <form action="{{route('upload_valid')}}" method="POST" enctype="multipart/form-data">
            	    <div class="form-group">
                      <b>Date: </b> {{$cur_validation[0]->date}}
                    </div>
                    <div class="form-group">
                       <b>Miniaplicator nmb: </b>{{$cur_validation[0]->minis->name}}
                    </div>
                    <div class="form-group">
                      <b>Connector: </b> {{$cur_validation[0]->minis->connector->name}}
                    </div>
                    <div class="form-group">
                       <b>Validation type: </b>{{ucfirst($cur_validation[0]->type_validation)}}
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                    	<input type="hidden" name='mini_name' value='{{$cur_validation[0]->minis->name}}'>
                		<input type="hidden" name='valid_id' value='{{$cur_validation[0]->id}}'>
                		<input type="hidden" name='valid_date' value='{{$cur_validation[0]->date}}'>
        			    <input type="hidden" name='valid_type' value='{{$cur_validation[0]->type_validation}}'>
                        <b>
                            Select file
                        </b>
                        <input type="file" class="form-control" id="file" name="validation">
                    </div>
                        <input type="submit" class="btn btn-primary" name='submit_validation' value="Upload validation">
                </form>
            </div>
        </div>
    </div>
@endsection

