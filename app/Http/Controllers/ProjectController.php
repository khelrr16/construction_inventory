<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{    
    //user
    public function prepare($id){
        Projects::where('id', $id)->update([
            'status' => 'preparing',
        ]);
        return redirect()->route('project.view',$id);
    }

    public function new(Request $request){  
        $request->validate([
            'project_name' => 'string|max:255|required',
            'description' => 'string|max:255|required',
        ]);
        Projects::create([
            'created_by' => auth()->guard()->id(),
            'project_name' => $request->project_name,
            'description' => $request->description,
        ]);
        return back()->with('success', 'Project added successfully!');
    }

    public function update(Request $request, $id, $submit){
        $request->validate([
            'worker_id' => 'required|exists:users,id',
            'description' => 'required|string|max:255',
            'house' => 'required|max:255',
            'barangay' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'zipcode' => 'integer|required|max:10000',
        ]);

        $project = Projects::findOrFail($id);
        $project->update($request->all());
        
        if($submit === 'true'){
            $project->update(['status' => 'processing']);
            return redirect()->route('admin.projects')->with('success', $project->project_name.' started processing!');
        }
        // if($project->items->isEmpty()){
        //     return back()->withErrors(['failed' => 'Empty resources.']);
        // }
        return back()->with('success', $project->project_name.' has been saved!');
    }

    public function save(Request $request, $id){
        $project = Projects::findOrFail($id);
        $project->update($request->all());
        return back()->with('success', 'Project saved successfully.');
    }

    public function destroy(Request $request, $id){
        $project = Projects::findOrFail($id);
        $project_name = $project->project_name;
        $project->delete();
        return back()->with('success', $project_name.' deleted successfully.');
    }
}
