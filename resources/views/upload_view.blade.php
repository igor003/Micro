
@extends('layouts.app')
@section('content')
    <script>
        function preview_images()
        {
            var total_file=document.getElementById("images").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#image_preview').append("<div class='col-md-3'><img class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
            }
        }
    </script>
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <b>Project:</b>{{ $conf[0]->codice->project->name}}<br>
                <b>Codice:</b>{{ $conf[0]->codice->name}}<br>
                <b>Components:</b>{{ $conf[0]->components}}<br>
                <b>Splice/Terminal:</b>{{ $conf[0]->connecting_element}}<br>
                <b>Sez Components:</b> {{$conf[0]->sez_components}}<br>
                <b>Number of Strands:</b> {{$conf[0]->nr_strand}}<br>
                <b>Height:</b> {{$conf[0]->height}}<br>
                <b>Width:</b> {{$conf[0]->width}}
            </div>
            <div class="col-xs-9">
                <form action="{{route('upload')}}" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <input type="file" class="form-control" id="images" name="images[]" onchange="preview_images()"  multiple >
                    </div>
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-primary" name='submit_image' value="Upload Multiple Image"/>
                    </div>
                    <p>Date:<input type="text" class="form-control" name="maked_at" id="datepicker_config" aria-describedby="emailHelp" placeholder="Enter date"></p>
                    <input type="hidden" name="id" value="{{$conf[0]->id}}">
                    <input type="hidden" name="project" value="{{$conf[0]->codice->project->name}}">
                    <input type="hidden" name="codice" value="{{$conf[0]->codice->name}}">
                    <input type="hidden" name="components" value="{{$conf[0]->components}}">
                    <input type="hidden" name="connector" value="{{$conf[0]->connecting_element}}">
                    <input type="hidden" name="strands" value="{{$conf[0]->nr_strand}}">
                    <input type="hidden" name="height" value="{{$conf[0]->height}}">
                    <input type="hidden" name="width" value="{{$conf[0]->width}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <div class="row" id="image_preview"></div>
            </div>

        </div>
    </div>

@endsection