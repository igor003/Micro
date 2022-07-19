
@extends('layouts.app')
@section('content')
 <div class="container">
        <div class="row">
            <div class="col-xs-offset-2 col-xs-8">
                <table id="report_table" class="table table-hover table-bordered"">
                    <thead>
                        <tr>
                            <td class="text-center">
                                Date
                            </td>
                            <td class="text-center">
                                Total Set up
                            </td>
                            <td class="text-center">
                                Set up with microsection
                            </td>
                            <td class="text-center">
                                Microsections performed
                            </td>
                            <td class="text-center">
                                Delete
                            </td>
                        </tr>
                    </thead>
                    <tbody id="table_reports">
                        @foreach($reports as $report)
                        <tr> 
                            <td class="text-center">{{$report->date}}</td>
                            <td class="text-center">{{$report->total_launch}}</td>
                            <td class="text-center">{{$report->total_micr}}</td>
                            <td class="text-center">{{$report->efectuated_micr}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

