<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Projects;
use App\Models\ProjectItems;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function view(Request $request, $id){
        $project = Projects::findOrFail($id);
        $project_items = ProjectItems::get();
        $items = Item::get();
        return view('project', compact('project','project_items', 'items'));
    }

    public function new(Request $request){
        $request->validate([
            'project_name' => 'required|string|max:255',
        ]);

        Projects::create([
            'created_by' => auth()->guard()->id(),
            'project_name' => $request->project_name,
        ]);

        return redirect()->route('/')->with('success', 'Project added successfully!');
    }
}
