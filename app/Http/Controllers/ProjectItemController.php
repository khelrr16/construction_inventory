<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectItems;

class ProjectItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $projectId = $request->project_id;

        if ($request->has('resources')) {
            foreach ($request->resources as $itemId) {
                ProjectItems::create([
                    'project_id' => $projectId,
                    'item_id'    => $itemId,
                    'quantity'   => 1 // default for now
                ]);
            }
            return redirect()->back()->with('success', 'Materials added successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
