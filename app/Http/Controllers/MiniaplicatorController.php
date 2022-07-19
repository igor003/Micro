<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connector;
use App\Miniaplicator;
use App\MiniCalibration;
use App\Http\Requests\ProjectRequest;
use App\Machine;
use Illuminate\Support\Facades\Auth;
use App\Part;
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
     public function update_view($id){
        $part = Miniaplicator::find($id);  
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
            return json_encode($mini->orderBy('name','asc')->get());
        }
        
        return json_encode($mini->orderBy('name','asc')->get());
    }


     public function add_calibration_view (Request $request)
     {
       
        $machines = Machine::all();
        $parts = Part::orderBy('name','asc')->get();

        return view('add_mini_calibration_view',['machines'=>$machines,'parts'=>$parts]);
    }

    public function add_mini_calibration(Request $request)
    {

        $errors = array();
        $curent = MiniCalibration::where('part_id',$request->codice)
                                ->where('miniaplicator_id',$request->mini)
                                ->where('components',$request->components)
                                ->where('machine_id',$request->machines)->first();
        
        if($curent){
            $errors[] = 'Tis record already exist!!' ;
             return view('mini_calibration_list',['errors'=>$errors]);
        }else{
            $mini_calib = new MiniCalibration;
            $mini_calib->part_id = $request->codice;
            $mini_calib->components = $request->components;
            $mini_calib->machine_id = $request->machines;
            $mini_calib->miniaplicator_id = $request->mini;
            $mini_calib->calibration_up = $request->calibr_up;
            $mini_calib->calibration_down = $request->calibr_down;
            $mini_calib->save();
        
            return redirect('/mini_calibaration_list_view');
        }

    }

    public function mini_calibration_list(Request $request)
    {
        if(Auth::user()->status == 'admin'){
            $admin = true;
        }else{
            $admin = false;
        }
        $all_mini_calib = MiniCalibration::select('*');

        if ( !is_null($request->search)) {
           $all_mini_calib->codice($request->search);
        }
        if ( !is_null($request->search2)) {
            $all_mini_calib->machine($request->search2);
        }
        if( !is_null($request->search3)){
            $all_mini_calib->mini($request->search3);
        }
     
         $res =  $all_mini_calib->with('codice')->with('minis.connector')->with('machines')->get();

        return  array('all_mini_calib'=>$res,'admin'=>$admin);
    }

    public function mini_calibration_list_view(Request $request)
    {

        return view('mini_calibration_list');
    }

    public function mini_calibration_delete($id)
    {
        $mini_calibr = MiniCalibration::findOrFail($id);
        $mini_calibr->delete();

        return redirect('mini_calibaration_list_view');
    }
    public function get_minis_by_terminal(Request $request){
       
        $minis =  Miniaplicator::where('connector_id','=',$request->connector)->get();
       
      
        return utf8_encode(json_encode($minis));
    }
    

}
