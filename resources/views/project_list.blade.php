@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-8 col-lg-4">
                <div class="input-group">
                    {{ csrf_field() }}
                    <input id="search_project" type="text" class="form-control" placeholder="Search for...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                <h4>
                    Projects
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
                <table id="projects_table" class="table table-hover table-bordered">
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
                    <tbody id="table_projects">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-4">

            </div>
        </div>
    </div>
    <script>

    </script>
@endsection