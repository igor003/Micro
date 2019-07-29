@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <a href="{{route('get_excell')}}">
                    <div class="btn btn-success">
                        Generate Excel
                    </div>
                </a>
            </div>
            <div class="col-xs-6">
                @if(Session::has('error_update')))
                    <div class="alert alert-danger">
                        <strong>Danger!</strong> Error in update
                    </div>
                @elseif(Session::has('successfully_update'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> Updated Successfully
                    </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input id="search_configuration" type="text" class="form-control" placeholder="Search for...">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-8  text-center">
                <h4>
                    Configuration
                </h4>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-10">
                <table id="configuration_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Codice
                        </td>
                        <td class="text-center">
                            Components
                        </td>
                        <td class="text-center">
                            Splice /<br>Terminal
                        </td>
                        <td class="text-center">
                            Components sez
                        </td>
                        <td class="text-center">
                            Total sez
                        </td>
                        <td class="text-center">
                            Number of strands
                        </td>
                        <td class="text-center">
                            Height
                        </td>
                        <td class="text-center">
                            Width
                        </td>
                       <!--  <td class="text-center">
                            Micros. list
                        </td> -->
                        @if(Auth::user()->status == 'admin')
                            <td class="text-center">
                                Update
                            </td>
                            <td class="text-center">
                                Delete
                            </td>
                        @endif   
                    </tr>
                    </thead>
                    <tbody id="table_configuration">
                    </tbody>
                </table>
            </div>
            <div class="col-lg-2">
                @foreach($projects as $project)
                    <input class="configur form-check-input" type="checkbox" value="{{$project->id}}" id="projects">
                    <label class=" project_label form-check-label" for="Project">
                        {{$project->name}}
                    </label>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection