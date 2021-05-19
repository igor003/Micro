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

                <form method="POST" action="{{route('add_connector')}}" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="machine_nmb">Connector name</label>
                        <input type="text" name="connector" class="form-control" id="connector" aria-describedby="emailHelp" placeholder="Enter connector name">
                        {{ csrf_field() }}
                    </div>
                    <div  class="form-group">
                        <label for="images3"> Connector image </label>
                        <input type="file" class="form-control" id="cannector_image" name="connector_img">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection