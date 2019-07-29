@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-xs-3">
            @if($errors)
                @foreach($errors->all() as $error)
                    <div class=" errors alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
        </div>

            <form id='form_configuration' method="POST" action="{{route('insert_configuration')}}">
                <div class="col-xs-3">
                <div class="form-group">
                    <label for="project_conf">Project</label>
                    <select name="project_configuration" class="form-control" id="project_conf_add">
                        <option  value="" selected></option>
                        @foreach($projects as $project)
                            <option value="{{$project->id}}">
                                {{$project->name}}
                            </option>
                        @endforeach
                    </select>
                    {{ csrf_field() }}
                </div>
                <div class="form-group">
                    <label for="codice_conf">Codice</label>
                    <select name="codice_configuration" class="form-control" id="codice_conf_add">
                        <option  value="" selected></option>
                        @foreach($codice as $part)
                            <option value="{{$part->id}}">
                                {{$part->name}}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Components</label>
                    <input type="text" name="components" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter components">

                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Terminal/Splice</label>
                    <input type="text" name="terminal" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter type of terminal/splice">

                </div>

                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="sez_comp">Sez Components</label>
                        <input type="text" name="sez_components" class="form-control" id="sez_comp" aria-describedby="emailHelp" placeholder="Enter sez components">

                    </div>
                    <div class="form-group">
                        <label for="strands">Amount of strands</label>
                        <input type="text" name="amount_strands" class="form-control" id="strands" aria-describedby="emailHelp" placeholder="Enter amount of strands">

                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" name="height" class="form-control" id="height" aria-describedby="emailHelp" placeholder="Enter height">

                    </div>
                    <div class="form-group">
                        <label for="height">Width</label>
                        <input type="text" name="width" class="form-control" id="width" aria-describedby="emailHelp" placeholder="Enter width">

                    </div>
                </div>
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-4"></div>
                    <div class="col-xs-4 text-center">
                        <button id="submit_form" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-xs-4"></div>
                </div>
            </form>


        <div class="col-xs-3"></div>

    </div>

</div>

@endsection