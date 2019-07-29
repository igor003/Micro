@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-offset-4 col-xs-4">
                <form method="POST" action="/photo/raport_generate">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Date from</label>
                        <input id="date_from" name='date_from' type="text" class="form-control" placeholder="Date from">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Date to</label>
                        <input id="date_to" name="date_to" type="text" class="form-control" placeholder="Date to">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="part">Select Part</label>
                       <select name="part" class="form-control" id="sel1">
                                <option  value="" selected></option>
                                @foreach($parts as $part)
                                    <option value="{{$part->id}}">
                                        {{$part->name}}
                                    </option>
                                @endforeach
                        </select>
                    </div><hr>
                    <div class="form-group">
                        <label for="project">Select Project</label>
                       <select name="project" class="form-control" id="sel1">
                                <option  value="" selected></option>
                                @foreach($projects as $project)
                                    <option value="{{$project->id}}">
                                        {{$project->name}}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            </div>
        </div>
    </div>

@endsection