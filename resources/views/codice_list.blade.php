@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-8 col-lg-4">
                <div class="input-group">
                    <input id="search_codice" type="text" class="form-control" placeholder="Search for...">
                    {{--<span class="input-group-btn">--}}
                        {{--<button id="search" class="btn btn-default" type="button">Go!</button>--}}
                    {{--</span>--}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8  text-center">
                <h4>
                    Codice
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="codice_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Name
                        </td>
                        @if(Auth::user()->status == 'admin')
                            <td class="text-center">
                                Update
                            </td>
                            <td class="text-center">
                                Delete
                            </td>
                            @endif
                    </thead>
                    <tbody id="table_codice">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 ">

                @foreach($projects as $project)
                    <input class="form-check-input" type="checkbox" value="{{$project->id}}" id="project">
                    <label class=" project_label form-check-label" for="Project">
                       <small>{{$project->name}}</small>
                    </label>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection