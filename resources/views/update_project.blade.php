
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
                <form method="POST" action="{{route('project_update')}}">
                    <div class="form-group">
                        <div class="form-group">
                            {{--<label for="sel1">Select project:</label>--}}
                            {{--<select name="project" class="form-control" id="sel1">--}}
                                {{--@foreach($projects as $project)--}}
                                    {{--@if($project->id == $project_id)--}}
                                        {{--<option selected value="{{$project->id}}">--}}
                                            {{--{{$project->name}}--}}
                                        {{--</option>--}}
                                    {{--@else--}}
                                        {{--<option value="{{$project->id}}">--}}
                                            {{--{{$project->name}}--}}
                                        {{--</option>--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                            <label for="exampleInputEmail1">Project</label>
                            <input name='name' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$project->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$project_id}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection