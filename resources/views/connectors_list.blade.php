@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-8 col-lg-4">
                <div class="input-group">
                    {{ csrf_field() }}
                    <input id="search_connector" type="text" class="form-control" placeholder="Search for...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                <h4>
                    Connectors
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
                <table id="connector_table" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center">
                                Name
                            </td>
                            <td class="text-center">
                                Specifications
                            </td>
                            <td class="text-center">
                                Update
                            </td>
                            <td class="text-center">
                                Delete
                            </td>
                        </tr>
                    </thead>
                    <tbody id="table_connector">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 text-center ">
                 <div class="input-group mb-3">
                    <button type="button" class="btn btn-primary">Add specifications</button>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection