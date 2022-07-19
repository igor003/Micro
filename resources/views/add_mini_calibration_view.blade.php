@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-4">
            <!-- @if($errors)
                @foreach($errors as $error)
                    <div class=" errors alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif -->
        </div>
        <form  method="POST" action="{{route('add_mini_calibration')}}">
             
            <div class="col-xs-3">
                <div class="form-group">
                    <label for="codice_conf">Codice</label>
                    <select name="codice" class="form-control" id="codice">
                        <option  value="" selected></option>
                        @foreach($parts as $part)
                            <option value="{{$part->id}}">
                                {{$part->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Components</label>
                    <select  name="components" class="form-control" id="calibr_components">
                    </select>
                </div>
                <div class="form-group">
                    <label for="mini">Miniaplicator</label>
                    <select name="mini" class="form-control" id="minis">
                        <option  value="" selected></option>
                        @foreach($minis as $mini)
                            <option value="{{$mini->id}}">
                                {{$mini->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="codice_conf">Machines</label>
                    <select name="machines" class="form-control" id="machiness">
                        <option  value="" selected></option>
                        @foreach($machines as $machine)
                            <option value="{{$machine->id}}">
                                {{$machine->number}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sez_comp">Calibration up</label>
                    <input type="text" name="calibr_up" class="form-control" id="sez_comp"  placeholder="Enter calibration up">
                </div>
                <div class="form-group">
                    <label for="sez_comp">Calibration down</label>
                    <input type="text" name="calibr_down" class="form-control" id="sez_comp"  placeholder="Enter calibration down">

                </div>
                 <div class="form-group text-center">
                      <button id="submit_form" type="submit" class="btn btn-primary">Submit</button>
                 </div>
                
            </div>
          
        </form>
    </div>

</div>

@endsection