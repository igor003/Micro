<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class InterfaceController extends Controller
{
 	public function index(){
 		$interfaces_names_res = Interfaces::whereNotNull('name')->distinct()->get([DB::raw('name as name')]);
 		$interfaces_names = array();
 		foreach($interfaces_names_res as $name){

			$interfaces_names[] = $name['name'];
 		}
 		$interfaces_code_res = Interfaces::whereNotNull('code')->distinct()->get([DB::raw('code as code')]);
 		$interfaces_code = array();
 		foreach($interfaces_code_res as $code){

			$interfaces_code[] = $code['code'];
 		}

 		$interfaces_blo_res = Interfaces::whereNotNull('blocket')->distinct()->get([DB::raw('blocket as blocket')]);
 		$interfaces_blo = array();
 		foreach($interfaces_blo_res as $blo){

			$interfaces_blo[] = $blo['blocket'];
 		}
 		

        return view('interfaces_view', ['interf_names'=>$interfaces_names,'interf_code'=>$interfaces_code,'interf_blo'=>$interfaces_blo]);
	}

	public function download(Request $request){
		$cur_interface = Interfaces::find($request->id);
		$cur_path = $cur_interface['path_'.$request->format];
		

		$storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
       
        $headers = [
            'Content-Type' => 'application.pdf',
            'Content-dispozition' => 'attachment; filename=result',
        ];
      
        return response()->download($storagePath.'interfaces/'.$cur_path, basename($cur_path), $headers);
	}

	public function get_list (Request $request){
		  
        $interfaces = Interfaces::select('*');
        if($request->name){
        	$interfaces->where('name','=',$request->name);
        }
        if($request->code){
        	$interfaces->where('code','=',$request->code);
        }
        if($request->blo){
        	$interfaces->where('blocket','=',$request->blo);
        }
       
        return $interfaces->get();
	}

	public function add_interface_view(){
		return view('interface_add_view');
	}

    public function get_jpg_by_id(Request $request){

        if($request->id){
            $id = substr($request->id, 4, 3);
             $data = Interfaces::find($id);
    $path = asset('storage/interfaces/'.$data['path_jpg']);

            return json_encode($path);
        }

    }
	public function upload_interfaces(Request $request){
   
		$filename_stl = $request->file('file_stl')->getClientOriginalName();
        $path_stl = $request->file('file_stl')->storeAs('public/interfaces\\'.$request->interface_name.'\\'.$request->blo_name1.'\\'.$request->interface_code, $filename_stl);
        $file_stl_path = $request->interface_name.'/'.$request->blo_name1.'/'.$request->interface_code.'//'.basename($filename_stl);
        
        $filename_f3d = $request->file('file_f3d')->getClientOriginalName();
        $path_f3d = $request->file('file_f3d')->storeAs('public/interfaces\\'.$request->interface_name.'\\'.$request->blo_name1.'\\'.$request->interface_code, $filename_f3d);
        $file_f3d_path = $request->interface_name.'/'.$request->blo_name1.'/'.$request->interface_code.'//'.basename($filename_f3d);

		$filename_jpg = $request->file('file_jpg')->getClientOriginalName();
        $path_jpg = $request->file('file_jpg')->storeAs('public/interfaces\\'.$request->interface_name.'\\'.$request->blo_name1.'\\'.$request->interface_code, $filename_jpg);
        $file_jpg_path = $request->interface_name.'/'.$request->blo_name1.'/'.$request->interface_code.'//'.basename($filename_jpg);
   
		$interface = new Interfaces;
        $interface->name = $request->interface_name;
        $interface->code = $request->interface_code;
        $interface->blocket = $request->blo_name1;
        $interface->path_stl = $file_stl_path;
        $interface->path_f3d = $file_f3d_path;
        $interface->path_jpg = $file_jpg_path;
        $interface->save();

        return redirect(route('interface_view'));
	}
    public function update_view($id){
        $data = Interfaces::find($id);
        return view('interface_update_view',['interface_date'=>$data]);
    }
    
    public function update_interface (Request $request){
       
         $path = Storage::disk('public')->getAdapter()->getPathPrefix();
         unlink($path.'/interfaces/'.$request->path_stl);
         unlink($path.'/interfaces/'.$request->path_f3d);
         unlink($path.'/interfaces/'.$request->path_jpg);
         

        $filename_stl = $request->file('file_stl_new')->getClientOriginalName();
        $path_stl = $request->file('file_stl_new')->storeAs('public/interfaces\\'.$request->interface_name.'\\'.$request->blo_name1.'\\'.$request->interface_code, $filename_stl);
        $file_stl_path = $request->interface_name.'/'.$request->blo_name1.'/'.$request->interface_code.'//'.basename($filename_stl);

        $filename_f3d = $request->file('file_f3d_new')->getClientOriginalName();
        $path_f3d = $request->file('file_f3d_new')->storeAs('public/interfaces\\'.$request->interface_name.'\\'.$request->blo_name1.'\\'.$request->interface_code, $filename_f3d);
        $file_f3d_path = $request->interface_name.'/'.$request->blo_name1.'/'.$request->interface_code.'//'.basename($filename_f3d);

        $filename_jpg = $request->file('file_jpg_new')->getClientOriginalName();
        $path_jpg = $request->file('file_jpg_new')->storeAs('public/interfaces\\'.$request->interface_name.'\\'.$request->blo_name1.'\\'.$request->interface_code, $filename_jpg);
        $file_jpg_path = $request->interface_name.'/'.$request->blo_name1.'/'.$request->interface_code.'//'.basename($filename_jpg);
        
        $interf = Interfaces::find($request->id);
        $interf->name = $request->interface_name;
        $interf->code=$request->interface_code;
        $interf->blocket=$request->blo_name1;
        $interf->path_stl=$file_stl_path;
        $interf->path_f3d=$file_f3d_path;
        $interf->path_jpg=$file_jpg_path;
        $interf->save();

        return redirect(route('interface_view'));
    }



}