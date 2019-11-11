@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-8 col-lg-4">
                <div class="input-group">
                    <input id="search_validarea" type="text" class="form-control" placeholder="Search for...">
                    {{--<span class="input-group-btn">--}}
                        {{--<button id="search" class="btn btn-default" type="button">Go!</button>--}}
                    {{--</span>--}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8  text-center">
                <h4>
                    Validations to be done
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="validation_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Date
                        </td>
                        <td class="text-center">
                            Miniaplicator nmb
                        </td>
                         <td class="text-center">
                            Connector
                        </td>
                        <td class="text-center">
                            Type validation
                        </td>
                        <td class="text-center">
                            Action
                        </td>
                    </thead>
                    <tbody id="table_validation">
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
