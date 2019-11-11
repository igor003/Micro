<?php

namespace App\Http\Controllers;
use App\Miniaplicator;
use App\MiniValidation;
use Illuminate\Http\Request;
use App\Connector;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class MiniValidationController extends Controller
{
	public function add_validation_view(){
		$minis = Miniaplicator::all();

		return view('add_validation',['minis'=>$minis]);
	}

	public function add_validation (Request $request){
		$validation = new MiniValidation;
        $validation->id_mini = $request->minaplicator_id;
        $validation->type_validation = $request->type_valid;
        $validation->status = $request->status;
        $validation->date = $request->date;
        $validation->save();

		return redirect('mini/validations');
	}

	public function validation_list_view(){
	
		return view('validation_list');
	}
	public function validation_list_done_view(){
	
		return view('validation_list_done');
	}

	public function validations_list(){
		$validatinos = MiniValidation::where('status','=','during')->with('minis.connector')->orderBy('date', 'desc')->get();
		
		return $validatinos;
	}

	public function validations_done_list(){
		$validatinos = MiniValidation::where('status','=','done')->with('minis.connector')->orderBy('date', 'desc')->get();
		
		return $validatinos;
	}

	public function upload_validation_view($id){


		$cur_validation = MiniValidation::where('id',$id)->with('minis.connector')->get();
		// exit($cur_validation);
		return view('upload_validation',['cur_validation'=>$cur_validation]);
	}


	public function upload_validation(Request $request){
		$filename = $request->file('validation')->getClientOriginalName();
        $path = $request->file('validation')->storeAs('validations\\'.$request->mini_name.'\\'.$request->valid_type.'\\'.$request->valid_date, $filename);
        
        $file_name = "storage/validations/".basename($filename);

        MiniValidation::where('id',$request->valid_id)->update(['path'=>$path,'status'=>'done']);

        return redirect(route('valid_list_view'));
	}

	public function download_validation(Request $request){
	    
	    $storagePath  = Storage::disk('validations')->getDriver()->getAdapter()->getPathPrefix();
        $headers = [
            'Content-Type' => 'application.pdf',
            'Content-dispozition' => 'attachment; filename=result',
        ];
		
        return response()->download($storagePath.substr($request->path,12), basename($request->path), $headers);
	}
}
