@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-4">

                @if($errors)
                    @foreach($errors->all() as $error)
                        <div class=" errors alert alert-danger">
   							{{$error}}
						</div>
                    @endforeach
                    @endif
            </div>
            <div class="col-xs-4">

                <form method="POST" action="{{route('add_connector')}}">
                    <div class="form-group">
                        <label for="machine_nmb">Connector name</label>
                        <input type="text" name="connector" class="form-control" id="connector" aria-describedby="emailHelp" placeholder="Enter connector name">
                        {{ csrf_field() }}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection