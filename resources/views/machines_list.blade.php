@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-8 col-lg-4">
                <div class="input-group">
                    <input id="search_machine" type="text" class="form-control" placeholder="Search for...">
                    {{--<span class="input-group-btn">--}}
                        {{--<button id="search" class="btn btn-default" type="button">Go!</button>--}}
                    {{--</span>--}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8  text-center">
                <h4>
                    Machines
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="machine_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Number
                        </td>
                        <td class="text-center">
                            Update
                        </td>
                        <td class="text-center">
                            Delete
                        </td>
                    </thead>
                    <tbody id="table_machines">
                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 ">

            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
