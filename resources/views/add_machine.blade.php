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

                <form method="POST" action="{{route('add_machine')}}">
                    <div class="form-group">
                        <label for="machine_nmb1">Machine nmb</label>
                        <input type="text" name="machine_nmb" class="form-control" id="machine_nmb1" aria-describedby="emailHelp" placeholder="Enter machine nmb">
                        {{ csrf_field() }}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection

