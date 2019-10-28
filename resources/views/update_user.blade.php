
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-4">

                @if($errors)
                    @foreach($errors->all() as $error)
                        <div class="errors alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="col-xs-4">
                <form method="POST" action="{{route('usr_update')}}">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input name='name' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$cur_user->name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input name='email' type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$cur_user->email}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="user">User</option>
                                <option value="minolog">Minolog</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$cur_user->id}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-xs-4"></div>
        </div>
    </div>

@endsection