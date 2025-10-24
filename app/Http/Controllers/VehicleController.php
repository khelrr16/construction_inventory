<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function driver_add(Request $request){
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
        ]);

        return back()->with('success', 'Vehicle was added.');
    }

    public function driver_edit(Request $request, $vehicle_id){
        $vehicle = Vehicle::findOrFail($vehicle_id);

        $request->validate([
            'type' => 'required',
            'brand' => 'required',
            'color' => 'required',
            'model' => 'required',
            'plate_number' => 'required|unique:vehicles,plate_number,'.$vehicle->id,
        ]);

        return redirect()
            ->route('driver.vehicles')
            ->with('success', 'Vehicle details edited.');
    }
}
