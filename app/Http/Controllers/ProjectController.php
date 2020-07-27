<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        return view('add_project');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProjectRequest $request)
    {
        $project = new Project;
        $project->name = $request->name;
        $project->save();
        return redirect('/home');
    }

    public function project_list_view(Request $request)
    {

        return view('project_list');
    }

    public function project_list(Request $request)
    {
        $project = Project::select('*');
        if ($request->search !== '') {
            $project->search($request->search);
        }
        if(Auth::user()->status == 'admin'){
            $admin = true;
        }else{
            $admin = false;
        }
        return response()->json(array('project' => $project->get(),'admin'=>$admin));
    }

    public function update_project_view($id)
    {
//        $projects = Project::all();
        $project = Project::find($id);
        return view('update_project', ['project' => $project, 'project_id' => $id]);
    }

    public function delete($id){
        $part = Project::find($id);
        $part->delete();
        return redirect('project_list_view');
    }

    public function update_project(Request $request)
    {

        
        Project::where('id', $request->id)->update(['name' => $request->name]);
        return redirect('project_list_view');
    }

}