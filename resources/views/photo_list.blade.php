@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-10">
                <table id="foto_list" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                            Date
                        </td>
                        <td class="text-center">
                            Codice
                        </td>
                        <td class="text-center">
                            Terminal/Splice
                        </td>
                        <td class="text-center">
                            Configuration
                        </td>
                        <td class="text-center">
                           Miniaplicator
                        </td>
                        <td class="text-center">
                           Machine nmb
                        </td>
                        <td class="text-center">
                          Operator
                        </td>
                        <td class="text-center">
                            Download
                        </td>
                        @if(Auth::user()->status == 'admin')
                            <td class="text-center">
                                Actions
                            </td>
                        @endif
                    </thead>
                    <tbody id="table_photo">
                    </tbody>
                </table>
                <nav class = "nav_pagination" aria-label="Page navigation example">
                  <ul id='pagin'class="pagination justify-content-center">
                    
                  </ul>
                </nav>
            </div>
            <div class="col-xs-2">
                <div class="form-group">
                    <label class=" project_label form-check-label" for="datepicker_photo_from">
                                  Enter date from  
                    </label>
                    <input id="datepicker_photo_from" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date from">
                </div>
                <div class="form-group">
                     <label class=" project_label form-check-label" for="datepicker_photo_from">
                                  Enter date to  
                    </label>
                    <input id="datepicker_photo_to" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date at">
                </div>
                 <div class="form-group">
                     <label class=" project_label form-check-label" for="work_order">
                                  Enter work order
                    </label>
                    <input name='work_order' id="work_ord" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter work order">
                </div>

                <a href="/photo/raport_view">
                    <div class="btn btn-info">
                        Generate raport
                    </div>
                </a>

                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Projects
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div id="projects" class="card-body">
                            @foreach($projects as $project)
                                    <input class="configur form-check-input" type="checkbox" value="{{$project->id}}" id="projects">
                                    <label class=" project_label form-check-label" for="Project">
                                        {{$project->name}}
                                    </label>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                  Codice
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div id="codice" class="card-body">
                                @foreach($codicies as $codice)
                                    @if($codice->id == $codice_id)
                                        <input checked class="configur form-check-input" type="checkbox" value="{{$codice->id}}" id="projects">
                                    @else
                                        <input class="configur form-check-input" type="checkbox" value="{{$codice->id}}" id="projects">
                                    @endif

                                    <label class=" project_label form-check-label" for="Project">
                                        {{$codice->name}}
                                    </label>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mini">Miniaplicator</label>
                    <select name="minaplicator" class="form-control" id="mini">
                        <option  value="" selected></option>
                         @foreach($minis as $mini)
                            <option value="{{$mini->id}}">
                                {{$mini->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="mini">Machine</label>
                    <select name="machine" class="form-control" id="machine">
                        <option  value="" selected></option>
                         @foreach($machines as $machine)
                            <option value="{{$machine->id}}">
                                {{$machine->number}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection