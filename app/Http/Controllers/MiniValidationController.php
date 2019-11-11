<?php

namespace App\Http\Controllers;
use App\Miniaplicator;
use App\MiniValidation;
use Illuminate\Http\Request;
use App\Connector;

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

	public function validations_list(){
		$validatinos = MiniValidation::where('status','=','during')->with('minis.connector')->orderBy('date', 'desc')->get();
		exit($validatinos);
		return $validatinos;
	}

	public function upload_validation_view($id){
		$cur_validation = MiniValidation::find($id)->with('minis.connector')->get();
		
		return view('upload_validation',['cur_validation'=>$cur_validation]);
	}


	public function upload_validation(){
		
	}
}
