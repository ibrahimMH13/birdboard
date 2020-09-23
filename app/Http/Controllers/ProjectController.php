<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function index()
    {
        $projects = auth()->user()->projects()->get();
        return view('projects.index')->with(['projects' => $projects]);
    }

    public function create(){
        return view('projects.create');
    }

    public function store()
    {
        $attribute = request()->validate([
            'title'       => 'required',
            'description' => 'required',
            'notes'       => 'sometimes|nullable'
         ]);
        $attribute['owner_id'] = auth()->id();
        $project =  \App\Models\Project::create($attribute);
        return redirect($project->path());
    }
    public function show(Project $project){
        if (auth()->user()->isNot($project->owner)){
            abort(403);
        }
        return view('projects.show',['project'=>$project]);
    }

    public function update(Project $project){

        /*   convert it to policy
           if(auth()->user()->isNot($project->owner)){
            abort(403);
        }
        */
        $this->authorize('update',$project);
        $project->update(\request(['notes']));
        return redirect($project->path());
    }
}
