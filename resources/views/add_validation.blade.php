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

                <form method="POST" action="{{route('add_validation')}}">
                    <div class="form-group">
                        <label for="machine_nmb1">Miniaplicator nmb</label>
                            <select name="minaplicator_id" class="form-control" id="mini">
                                <option  value="" selected></option>
                                @foreach($minis as $mini)
                                    <option value="{{$mini->id}}">
                                        {{$mini->name}}
                                    </option>
                                @endforeach
                            </select>
                        {{ csrf_field() }}
                    </div>
                    <div class="form-group">
                        <label for="machine_nmb1">Type Validation</label>
                        <select name="type_valid" class="form-control" id="mini">
                            <option  value="" selected></option>
                            <option  value="initial">Initial</option>
                            <option  value="ordinary">Ordinary</option>
                            <option  value="extraordinary">Extraordinary</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label  for="datepicker_photo_from">
                                  Enter date from  
                        </label>
                        <input id="datepicker_photo_from" name='date' type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date from">
                    </div>
                   
                    <input type="hidden" name='status' value='during'>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div> 
    </div>
    <script>

    </script>
@endsection
