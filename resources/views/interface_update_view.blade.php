@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8  text-center">
                <h4>
                    Interfaces
                </h4>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form id='add_interface' action="{{route('update_interf')}}" method="post" enctype="multipart/form-data">
                    <label for="codice_conf">Interface name</label>
                    <input value='{{$interface_date["name"]}}' type="text" class="form-control" name="interface_name" id="interf_name" aria-describedby="emailHelp" placeholder="Enter interface name">
                     <label for="codice_conf">Blocket name </label>
                    <input value='{{$interface_date["blocket"]}}' type="text" class="form-control" name="blo_name1" id="blo_name" aria-describedby="emailHelp" placeholder="Enter blocket name">
                    <label for="codice_conf">Interface Code </label>
                    <input value='{{$interface_date["code"]}}' type="text" class="form-control" name="interface_code" id="interf_code" aria-describedby="emailHelp" placeholder="Enter interface code">
                    <div class="row">
                    
                        <div class="col-md-12">
                            <label for="images1"> File STL format </label>
                            <input type="file" class="form-control" id="images1" name="file_stl_new">
                        </div>
                        <div class="col-md-12">
                            <label for="images2"> File F3D format </label>
                            <input type="file" class="form-control" id="images2" name="file_f3d_new">
                        </div>
                        <div class="col-md-12">
                            <label for="images3"> File JPG format </label>
                            <input type="file" class="form-control" id="images3" name="file_jpg_new">
                              <input type="hidden" name="id" value="{{$interface_date['id']}}">
                              <input type="hidden" name="path_stl" value="{{$interface_date['path_stl']}}">
                              <input type="hidden" name="path_f3d" value="{{$interface_date['path_f3d']}}">
                              <input type="hidden" name="path_jpg" value="{{$interface_date['path_jpg']}}">
                        </div>
                    </div>
                      {{ csrf_field() }}
                    <div class="row text-center">
                        <button type='submit' class='btn btn-success'>Submit</button>
                        
                    </div>
                  
                </form>
                 
            </div>
            <div class="col-xs-2 ">
            
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
