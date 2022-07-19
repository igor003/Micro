@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
	           	<table id="users_table" class="table table-hover table-bordered">
                    <thead>
		                <tr>
		                    <td class="text-center">
		                        Name
		                    </td>
		                    <td class="text-center">
		                        Email
		                    </td>
		                    <td class="text-center">
		                       Status
		                    </td>
		                    <td class="text-center">
		                        Update
		                    </td>
		                    <td>
		                    	Delete
		                    </td>
		                </tr>
                    </thead>
                    <tbody id="table_users">
                    	@foreach ($users as $user)
 							<tr class='text-center'>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->status}}
                                </td>
                                <td>
                                    <a href="user/update_view/{{$user->id}}"> <div><img height="40px" width = "40px" src="/img/update.png" alt=""></div></a>
                                </td>
                                <td>
                                    <a href="user/delete/"> <div><img height="40px" width = "40px" src="/img/delete.png" alt=""></div ></a>
                                </td>
                            </tr>
                    	@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection