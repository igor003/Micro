@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-4">

                @if($errors)
                    @foreach($errors->all() as $error)
                        <div class="errors alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-xs-4">
                <form method="POST" action="{{route('create_codice')}}">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="sel1">Select project:</label>
                            <select name="project" class="form-control" id="sel1">
                                <option  value="" selected></option>
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">
                                        {{$project->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Codice name</label>
                        <input type="text" name="codice_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter codice name">
                        {{ csrf_field() }}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection