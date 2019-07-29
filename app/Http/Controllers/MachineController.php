<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machine;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Auth;
class MachineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
        return view('add_machine');
    }

    public function create(Request $request){
    	$machine = new Machine;
        $machine->number = $request->machine_nmb;
        $machine->save();

       	return redirect('/home');
    }

    public function delete($id){
        $part = Machine::find($id);
        $part->delete();
        return redirect('machine_list_view');
    }

    public function machines_list_view(){
        $machines = Machine::all();
        return view('machines_list',['machines'=>$machines]);
    }
    public function machines_list(Request $request)
    {
        $machines = Machine::select('*');
        if ( !is_null($request->search)) {
            $machines->search($request->search);

            return  $machines->get();
        }
        if(Auth::user()->status == 'admin'){
            $admin = true;
        }else{
            $admin = false;
        }
         return array('machines'=>$machines->get(),'admin'=>$admin);
    }
}
