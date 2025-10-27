<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function admin_add(Request $request){
        $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'color' => 'required',
            'model' => 'required',
            'plate_number' => 'required|unique:vehicles,plate_number',
        ]);

        Vehicle::create([
            'type' => $request->type,
            'brand' => $request->brand,
            'color' => $request->color,
            'model' => $request->model,
            'plate_number' => $request->plate_number,
            'registered_by' => auth()->guard()->id(),
            'status' => 'inactive',
        ]);

        return back()->with('success', 'Vehicle was added.');
    }

    public function admin_edit(Request $request, $vehicle_id){

        $vehicle = Vehicle::findOrFail($vehicle_id);
        $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'color' => 'required',
            'model' => 'required',
            'plate_number' => 'required|unique:vehicles,plate_number,'.$vehicle->id,
            'status' => 'required',
        ]);

        $vehicle->update($request->all());
        return redirect()
            ->route('admin.vehicles')
            ->with('success', 'Vehicle details updated.');
    }
}
