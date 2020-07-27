<?php

namespace App\Http\Controllers;

use App\Http\Requests\CodiceRequest;
use App\Http\Requests\CodiceUpdateRequest;
use App\Part;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Elasticsearch\ClientBuilder;
class CodiceController extends Controller
{

    public static function convert_from_latin1_to_utf8_recursively($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }
    public function index()
    {
        $projects = Project::all();
        return view('add_codice', ['projects' => $projects]);
    }

    public function create(CodiceRequest $request)
    {
        $codice = new Part;
        $codice->name = $request->codice_name;
        $codice->project_id = $request->project;
        $codice->save();
        return redirect('/home');
    }

    public function get_by_id(Request $request)
    {
        return Part::where('project_id', '=', $request->project_id)->get();
    }

    public function get_by_id_project(Request $request)
    {
        $part = Part::find($request->codice_id);
        return $part->project;
    }

    public function codice_list_view(Request $request){

       
        
        $projects = Project::all();
        return view('codice_list',['projects'=>$projects]);
    }

    public function codice_list(Request $request){
          
//
//        if($request->filter and $request->search){
//            $parts = Part::search($request->search)->filter($request->filter)->get();
//            return $parts;
//        }else if($request->search){
//            $parts = Part::search($request->search)->get();
//            return $parts;
//        }else if ($request->filter) {
//            $parts = Part::filter($request->filter)->get();
//            return $parts;
//        }
//            $parts = Part::all();
//            return $parts;
//            


// $client = ClientBuilder::create()->build();
// $params = [
//     'index' => 'my_index',
//     'id'    => 'my_id',
//     'type'  => '_doc',
//     'body'  => ['testField' => 'abc']
// ];

// $response = $client->index($params);
// $params = [
//     'index' => 'my_index',
//     'type'  => '_doc',
//     'id'    => 'my_id'
// ];

// $response = $client->get($params);



// var_dump($response);
  
        $parts = Part::select('*');
        
        if($request->search != ''){
            $parts->search($request->search);
        }

        if ($request->filter != '') {
            $parts->filter($request->filter);
        }

        if(Auth::user()->status == 'admin'){
            $admin = true;
        }else{
            $admin = false;
        }
        
        return $this->convert_from_latin1_to_utf8_recursively(array('parts' => $parts->get(),'admin'=>$admin));
    }

    public function delete($id)
    {
        $part = Part::find($id);
        $part->delete();
        return redirect('codice_list_view');
    }

    public function get_by_project(Request $request)
    {
        $result =  Part::where('project_id','=',$request->filter)->get();
        return $result->toArray();
    }

    public function update_view ($id){
        $projects = Project::all();
        $part = Part::find($id);
        return view('update_codice',['part'=>$part,'projects'=>$projects]);
    }
    public function update_codice(CodiceUpdateRequest $request){
        Part::where('id',$request->id)->update(['name'=>$request->name,'project_id'=>$request->project]);
        return redirect('codice_list_view');
    }
}