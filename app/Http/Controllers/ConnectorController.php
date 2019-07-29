<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use App\Connector;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;


class ConnectorController extends Controller
{
    public function index()
    {
        return view('add_connector');
    }

 	public function create(Request $request){
    	$project = new Connector;
        $project->name = $request->connector;
        $project->save();

       	return redirect('/home');
    }

	 public function connectors_list_view(){
        $connectors = Connector::orderBy('name','asc')->get();
        return view('connectors_list',['connectors'=>$connectors]);
    }

    public function connector_list(Request $request)
    {
        $connector = Connector::select('*');
        if ( !is_null($request->search)) {
            $connector->search($request->search);

           return array('connectors'=>$connector->orderBy('name','asc')->get());
        }
       
        if(Auth::user()->status == 'admin'){
            $admin = true;
        }else{
            $admin = false;
        }

        return array('connectors'=>$connector->orderBy('name','asc')->get(),'admin'=>$admin);
    }
  
}
