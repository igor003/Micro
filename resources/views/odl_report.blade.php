@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-2">

                
            </div>
            <div class="col-xs-8">
            	<table id="codice_table" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td class="text-center">
                           ODL number
                        </td>
                        <td class="text-center">
                           Codice
                        </td>
                        <td>
                        	Components
                        </td>
                        <!-- <td class="text-center">
                          Operator
                        </td> -->
                        <td class="text-center">
                           Recive time
                        </td>
                        <td class="text-center">
                           Mivrograf. start time
                        </td>
                        <td class="text-center">
                           Micrograf. end time
                        </td>
                        <td class="text-center">
                            Reaction time <br> (min)
                        </td>
                        <td class="text-center">    
                            Execution time
                        </td>
                    </tr>
                    </thead>
                    <tbody id="table_odl">
                    	@foreach($data as $row)
                    		<tr>
                    			<td>
                    				{{$row['order_number']}}
                    			</td>
                    			<td>
                    				{{$row['codice']}}
                    			</td>
                    			<td>
                    				{{$row['components']}}
                    			</td>
                    			<!-- <td>
                    				{{$row['operator']}}
                    			</td> -->
                    		
                    			<td class="text-center">
                    				{{$row['recive_date']}}
                    			</td>
                    		
                    			<td class="text-center">
                    				{{$row['start_date']}}
                    			</td>
                                <td class="text-center">
                                    {{$row['maked_at']}}
                                </td>
                    	
                    			<td class="text-center">
                    				{{$row['diff_min']}}
                    			</td>
                                <td class="text-center">    
                                    {{$row['exec']}}
                                </td>   
                    		</tr>
                    	@endforeach
                    </tbody>
                </table>
                
            </div>
            <div class="col-xs-2"></div>
        </div>
    </div>

@endsection