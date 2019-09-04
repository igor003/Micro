<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use App\Connector;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function upload_specification_view()
    {
        $connectors = Connector::all();
        return view('upload_specifications',['connectors'=>$connectors]);
    }

    public function upload_specifications (Request $request){

        $filename = $request->file('specifications')->getClientOriginalName();
        $path = $request->file('specifications')->storeAs('specifications\\', $filename);
        
        $file_name = "storage/specifications/".basename($filename);

        Connector::where('id',$request->connector)->update(['specification_path'=>$file_name]);

        return redirect(route('connector_list_view'));
    }

    public function download_specification(Request $request){

        $storagePath  = Storage::disk('specifications')->getDriver()->getAdapter()->getPathPrefix();
        $headers = [
            'Content-Type' => 'application.pdf',
            'Content-dispozition' => 'attachment; filename=result',
        ];

        return response()->download($storagePath.basename($request->path), basename($request->path), $headers);
    }
  
}
