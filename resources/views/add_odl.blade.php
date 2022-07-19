@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-4">

            </div>
            <div class="col-xs-4">

                <form method="POST" action="{{route('add_odl')}}">
                    <div class="form-group">
                        <label for="machine_nmb1">ODL</label>
                        <input type="text" name="odl_number" class="form-control" id="odl" aria-describedby="emailHelp" placeholder="Enter odl nmb">
                        {{ csrf_field() }}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection

