@extends('layouts.app')

@section('content')
 <script src="{{ asset('js/interfaces_list.js')}}"></script>
    <div class="container">
        <div class="row">
            <div id='preview' style="height:100px; with:200px; position:absolute; z-index:5;">
                
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-8  text-center">
                <h4>
                    Interfaces
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <table id="interfaces_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Id
                        </td>
                        <td class="text-center">
                            Interface name
                        </td>
                        <td class="text-center">
                            Code interface
                        </td>
                        <td class="text-center">
                            Blocket name
                        </td>
                        <td class="text-center">
                            File .STL
                        </td>
                        <td class="text-center">
                            File .F3D
                        </td>
                        <td class="text-center">
                            File .JPG
                        </td>
                        <td class="text-center">
                            Update
                        </td>
                    </thead>
                    <tbody id="interfaces_body">


                    </tbody>
                </table>
            </div>
            <div class="col-xs-2 ">
                <div class="form-group">
                    <label for="name_interface">Select name interface</label>
                    <select name="name" class="form-control" id="name_interface">
                        <option  value="" selected></option>
                        @foreach($interf_names as $name)
                            <option value="{{$name}}">
                                {{$name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="code_interface">Select code interface</label>
                    <select name="code" class="form-control" id="code_interface">
                        <option  value="" selected></option>
                        @foreach($interf_code as $code)
                            <option value="{{$code}}">
                                {{$code}}
                            </option>
                        @endforeach
                    </select>
                </div>
                   <div class="form-group">
                    <label for="blocket_interface">Select blocket</label>
                    <select name="blo" class="form-control" id="blocket_interface">
                        <option  value="" selected></option>
                        @foreach($interf_blo as $blo)
                            <option value="{{$blo}}">
                                {{$blo}}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>
        </div>
    </div>
    
@endsection
