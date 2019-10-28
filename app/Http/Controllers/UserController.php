<?php

namespace App\Http\Controllers;
Use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index (){
	    $users = User::all();
    	return view('admin_panel',['users'=>$users]);
    }

    public function update_view ($id){
        $cur_user = User::find($id);

        return view('update_user',['cur_user'=>$cur_user]);
    }

    public function update(Request $request){
    	$user = User::find($request->id);
        $user->name = $request->name;
        $user->email=$request->email;
        $user->status=$request->status;
        $user->save();
        return redirect(route('usr_list'));
    }
}
