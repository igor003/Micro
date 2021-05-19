<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MachineLumberg;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Auth;
class MachineLumbergController extends Controller
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
    public function index(){
 
    }

    public function create(Request $request){
    	
    }

    public function delete($id){
        
    }

    public function machines_list_view(){
        
    }

    public function machines_list(Request $request){
        
    }
}
