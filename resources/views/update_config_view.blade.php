
@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <form id='form_configuration' method="POST" action="{{route('update_configuration')}}">
                <div class="col-xs-3"></div>
                <div class="col-xs-3">
                            <div class="form-group">
                    <label for="project_conf">Departament</label>
                    <select name="department" class="form-control" id="dep">
                           
                            <option value="P1">P1 @if($config[0]->id == 'P1') selectted @endif</option>
                            <option value="P1">P2 @if($config[0]->id == 'P2') selectted @endif</option>
                    </select>
               
                </div>
                    <div class="form-group">
                        <label for="project_conf">Project</label>
                        <select name="project_configuration" class="form-control" id="project_conf">
                            <option  value="" selected></option>
                            @foreach($projects as $project)
                                @if($project->id == $config[0]->codice->project->id)
                                    <option selected value="{{$project->id}}">
                                        {{$project->name}}
                                    </option>
                                @else
                                    <option value="{{$project->id}}">
                                        {{$project->name}}
                                    </option>
                                @endif

                            @endforeach
                        </select>
                        {{ csrf_field() }}
                    </div>
                    <div class="form-group">
                        <label for="codice_conf">Codice</label>
                        <select name="codice_configuration" class="form-control" id="codice_conf_update">
                            <option  value="" selected></option>
                            @foreach($codice as $part)
                                @if($part->id == $config[0]->codice->id)
                                    <option selected="selected" value="{{$part->id}}">
                                        {{$part->name}}
                                    </option>
                                @else
                                    <option value="{{$part->id}}">
                                        {{$part->name}}
                                    </option>
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Components</label>
                        <input type="text" value="{{$config[0]->components}}" name="components" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter components">

                    </div>
                  
                    <div class="form-group">
                        <label for="codice_conf">Terminal/Splice</label>
                        <select name="connector" class="form-control" id="codice_conf_update">
                            <option  value="" selected></option>
                            @foreach($connectors as $connector)
                                @if($connector->id == $config[0]->connector->id)
                                    <option selected="selected" value="{{$connector->id}}">
                                        {{$connector->name}}
                                    </option>
                                @else
                                    <option value="{{$connector->id}}">
                                        {{$connector->name}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="sez_comp">Sez Components</label>
                        <input type="text" value="{{$config[0]->sez_components}}"  name="sez_components" class="form-control" id="sez_comp" aria-describedby="emailHelp" placeholder="Enter sez components">

                    </div>
                    <div class="form-group">
                        <label for="sez_comp">Total section</label>
                        <input type="text" value="{{$config[0]->total_sez}}"  name="total_sez" class="form-control" id="total_sez" aria-describedby="emailHelp" placeholder="Enter total section">

                    </div>
                    <div class="form-group">
                        <label for="strands">Amount of strands</label>
                        <input type="text" value="{{$config[0]->nr_strand}}" name="amount_strands" class="form-control" id="strands" aria-describedby="emailHelp" placeholder="Enter amount of strands">

                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" value="{{$config[0]->height}}" name="height" class="form-control" id="height" aria-describedby="emailHelp" placeholder="Enter height">

                    </div>
                    <div class="form-group">
                        <label for="height">Width</label>
                        <input type="text" value="{{$config[0]->width}}" name="width" class="form-control" id="width" aria-describedby="emailHelp" placeholder="Enter width">
                        <input name="config_id" type="hidden" value="{{$config[0]->id}}">
                        <input type="hidden" value="{{$config[0]->id}}" name ="id">
                    </div>
                </div>
                <div class="col-xs-3"></div>
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-4 text-center">
                        <button id="submit_form" type="submit" class="btn btn-warning">Update</button>
                    </div>
                    <div class="col-xs-4"></div>
                </div>
            </form>
        </div>

    </div>

@endsection