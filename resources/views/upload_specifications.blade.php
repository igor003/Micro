
@extends('layouts.app')
@section('content')
 <div class="container">
        <div class="row">

            <div class="col-xs-4"></div>
            <div class=" col-xs-4 ">
                <form action="{{route('upload_specif')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class=" project_label form-check-label" for="file">
                            Select file
                        </label>
                        <input type="file" class="form-control" id="file" name="specifications">
                    </div>
                    <div class="form-group">
                        <select name="connector" class="form-control" id="connector">
                            @foreach($connectors as $connector)

                                <option selected value="{{$connector->id}}">
                                    {{$connector->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                        <input type="submit" class="btn btn-primary" name='submit_excell' value="Upload specifications">
                </form>
            </div>
        </div>
    </div>
@endsection

