<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connector;
use App\Miniaplicator;
use App\Http\Requests\ProjectRequest;

class MiniaplicatorController extends Controller
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
 		$connectors = Connector::all();

        return view('add_miniaplicator',['connectors'=>$connectors]);
    }

    public function create(Request $request){
    	$project = new Miniaplicator;
        $project->name = $request->miniaplicator_nmb;
        $project->connector_id = $request->connector;
        $project->save();

       	return redirect('/home');
    }

    public function delete($id){
        $part = Miniaplicator::find($id);
        $part->delete();

        return redirect('miniaplicator_list_view');
    }

    public function miniaplicators_list_view(){
        $connectors = Connector::orderBy('name','asc')->get();

        return view('miniaplicators_list',['connectors'=>$connectors]);
    }

    public function miniaplicator_list(Request $request)
    {
        $mini = Miniaplicator::select('*');
        if ( !is_null($request->search)) {
            $mini->search($request->search);

            return  $mini->orderBy('name','asc')->get();
        }
        if(!is_null($request->filter)){
            // $mini = Miniaplicator::whereHas('connector',function ($query) use($request) {
            //     $query->whereIn('connector_id',$request->filter);
            // })->with('connector');
            // $mini = Miniaplicator::select('*');
            $mini->filter($request->filter);
            return $mini->orderBy('name','asc')->get();
        }
        
        return $mini->orderBy('name','asc')->get();
    }

}
