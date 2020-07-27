
@extends('layouts.app')
@section('content')

  
<script type="text/javascript">

</script>
 <div class="container">
    <div class="row">
        <div class="col-xs-10 text-center">
            
            <h1 id='cur_date'></h1>
        </div>
    </div>
        <div class="row">

            <div class="col-xs-10">
                <div id="columnchart_material"></div>
            </div>
            <div class="col-xs-2">
              
                <div class="form-group">
                       <label  for="datepicker_exec">
                                  Enter date 
                            </label>
                         <div class="form-group center">
                          
                            <input id="datepicker_exec" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter date ">
                           
                        </div>   
                     
                </div>
            </div>
        </div>
        <div  class="row text-center">  
            <div id='media' class="col-xs-10 text-center">
            
          
            </div>
        </div>
    </div>
@endsection

