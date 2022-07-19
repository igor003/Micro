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
            <div id='codice_project' class="col-md-offset-2 col-md-8  text-center">
                
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
                <table id="codice_bom_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Codice
                        </td>
                        <td class="text-center">
                            Modification
                        </td>
                        <td class="text-center">
                            Download Bom
                        </td>

                     
                    <tbody id="table_bom_codice">
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