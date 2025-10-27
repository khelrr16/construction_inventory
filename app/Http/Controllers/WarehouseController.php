<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function admin_new(Request $request){
        $request->validate([
            'status' => 'required',
            'name' => 'required|max:255',
            'house' => 'required|max:255',
            'barangay' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'zipcode' => 'integer|required|max:10000',
        ]);

        Warehouse::create($request->all());
        return back()->with('success','Warehouse created successfully.');
    }

    public function admin_update(Request $request, $warehouse_id){
        $warehouse = Warehouse::findOrFail($warehouse_id);

        $request->validate([
            'status' => 'required',
            'name' => 'required|max:255',
            'house' => 'required|max:255',
            'barangay' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'zipcode' => 'integer|required|max:10000',
        ]);

        $warehouse->update($request->all());
        return redirect()
            ->route('admin.warehouses')
            ->with('success', 'Warehouse updated successfully.');
    }
}
