<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vehicle;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\ResourceStatus;
use App\Models\ProjectResource;
use App\Models\ProjectResourceItem;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function resource_new(Request $request, $project_id){
        $request->validate([
            'warehouse_id' => 'required',
        ]);
        ProjectResource::create([
            'project_id' => $project_id,
            'warehouse_id' => $request->warehouse_id,
            'created_by' => auth()->guard()->id(),
            'status' => 'draft',
        ]);

        return back()->with('success', 'Resource was created.')->withFragments('resourceTabsContent');
    }

    public function resource_update(Request $request, $resource_id, $submit){
        $request->validate([
            'remark' => 'max:200',
            'schedule' => 'required|date|after_or_equal:today',
        ]);
        $resource = ProjectResource::findOrFail($resource_id);
        $resource->update($request->all());

        if($submit === 'true'){
            $resource_items = ProjectResourceItem::where('resource_id', $resource_id)->get();
            if($resource_items->isEmpty()){
                return back()->withErrors('No items were added!')
                    ->with('active_tab', $resource_id)
                    ->withFragment('resourceTabsContent');
            }

            $resource->update(['status' => 'pending']);
            
            foreach($resource_items as $item){
                $item->update(['status' => 'pending']);
            }
            ResourceStatus::create([
                'project_id' => $resource->project_id,
                'resource_id' => $resource_id,
                'status' => 'Awaiting Approval',
                'description' => 'Request was sent. Waiting for admin to respond.',
            ]);
            return redirect()->route('worker.project.view', $resource->project_id)->with(['success' =>'Resource sent for approval!']);
        }
        return back()->with(['success' =>'Resource updated successfully!'])->withFragment('resourcesTable');
    }

    public function item_add(Request $request, $resource_id){
        $resource = ProjectResource::findOrFail($resource_id);

        if ($request->has('resource_items')) {
            foreach ($request->resource_items as $index => $item) {
                ProjectResourceItem::create([
                    'project_id' => $resource->project_id,
                    'resource_id' => $resource->id,
                    'item_id'    => $index,
                    'quantity'   => 1,
                    'status' => 'Draft',
                ]);
            }
            return redirect()
                ->route('worker.resource.edit', $resource->id)
                ->with(['success' =>'Resource added successfully!']);
        }
        return back()->withErrors('No items selected!')
            ->with('active_tab', $resource_id);
    }

    public function item_update(Request $request, $resource_id){
        if ($request->has('resource_items')) {
            foreach ($request->resource_items as $index => $quantity) {
                $item = ProjectResourceItem::where('id', $index);
                $item->update(['quantity' => $quantity]);
            }
            return back()->with(['success' =>'Resource items updated successfully!'])->withFragment('resourcesTable');
        }
        return back()->withErrors('No items were found!')
            ->with('active_tab', $resource_id)
            ->withFragment('resourcesTable');
    }

    public function item_delete(Request $request, $resource_id){
        if ($request->has('resource_items')) {
            foreach ($request->resource_items as $item_id) {
                $item = ProjectResourceItem::findOrFail($item_id);
                if($item->status == 'draft'){
                    $item->forceDelete();
                }
                $item->delete();
            }
            return back()->with(['success' =>'Resource items removed successfully!'])->withFragment('resourcesTable');
        
        }
        return back()->withErrors('No items selected!')
            ->with('active_tab', $resource_id)
            ->withFragment('resourcesTable');
    }

    public function request_update_resource(Request $request, $resource_id, $value){
        $resource = ProjectResource::findOrFail($resource_id);
        $resource_items = ProjectResourceItem::where('resource_id', $resource_id)->get();

        if($value){
            $resource->update([
                'approved_by' => Auth::id(),
                'remark' => $request->remark,
                'status' => 'to be packed',
            ]);

            foreach($resource_items as $item){
                $item->update(['status' => 'to be packed']);
            }

            ResourceStatus::create([
                'project_id' => $resource->project_id,
                'resource_id' => $resource_id,
                'status' => 'To Be Packed',
                'description' => 'Resource request approved.',
            ]);

            return back()->with('success', 'Resource request approved.');
        }
        else{
            $resource->update([
                'clerk_id' => $request->clerk_id,
                'remark' => $request->remark,
                'status' => 'declined',
            ]);

            foreach($resource_items as $item){
                $item->update(['status' => 'declined']);
            }
            
            ResourceStatus::create([
                'project_id' => $resource->project_id,
                'resource_id' => $resource_id,
                'status' => 'Declined',
                'description' => 'Resource request was declined for whatever reason.',
            ]);

            return back()->with('success', 'Resource request declined.');
        }
    }
    public function resource_prepare($resource_id){

        $resource = ProjectResource::findOrFail($resource_id);
        $resource_items = ProjectResourceItem::where('resource_id', $resource_id)->get();
        $resource->update([
            'prepared_by' => Auth::id(),
            'status' => 'packing',
        ]);

        foreach($resource_items as $item){
            $item->status = 'packing';
            $item->save();
        }
        ResourceStatus::create([
            'project_id' => $resource->project_id,
            'resource_id' => $resource_id,
            'status' => 'Packing',
            'description' => 'Items are getting prepared.',
        ]);
        
        return back()->with('success', 'Resource sent to preparations.');
    }

    public function resource_prepare_complete(Request $request, $resource_id){

        $resource = ProjectResource::findOrFail($resource_id);
        
        foreach($request->supplied as $index => $supplied){
            $resource_item = ProjectResourceItem::findOrFail($index);
            $resource_item->update(['supplied' => $supplied]);
            $item = Item::findOrFail($resource_item->item_id);
            
            if($supplied != $resource_item->quantity){
                return back()->withErrors('Quantity and supply do not match.');
            }
            else if($supplied > $item->stocks){
                return back()->withErrors('Insufficient stocks.');
            }
        }

        $request->validate(['driver_id' => 'required']);
        $resource->driver_id = $request->driver_id;
        $resource->save();
        
        $stock_items = Item::all()->keyBy('id'); // keyBy makes lookups faster
        $resource_items = ProjectResourceItem::where('resource_id', $resource_id)->get();
        
        foreach($resource_items as $index => $item){
            if($item->supplied > $stock_items[$item->item_id]->stocks){
                return back()->withErrors(' Invalid input! Not enough stocks.');
            }
            if($item->supplied > $item->quantity){
                return back()->withErrors('Invalid input! Too much supply.');
            }
        }

        foreach($resource_items as $index => $item){
            $stock_items[$item->item_id]->stocks -= $item->quantity;
            $stock_items[$item->item_id]->save();
            $item->status = 'to be delivered';
            $item->save();
        }

        $resource->status = 'to be delivered';
        $resource->save();

        ResourceStatus::create([
            'project_id' => $resource->project_id,
            'resource_id' => $resource_id,
            'status' => 'Ready for Delivery',
            'description' => 'All items have been supplied. It is now ready for delivery.',
        ]);

        return redirect()->route('clerk.requests')->with('success', value: 'Resource is ready for delivery!');
    }

    public function resource_delivery_start(Request $request, $resource_id){
        $resource = ProjectResource::findOrFail($resource_id);
        $resource_items = ProjectResourceItem::where('resource_id', $resource_id)->get();
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        if($vehicle->status == 'occupied'){
            return back()->withError(['Vehicle is already occupied.']);
        }

        $resource->update(['status' => 'on delivery']);
        foreach($resource_items as $index => $item){
            $item->update(['status' => 'on delivery']);
        }
        $vehicle->status = 'occupied';
        $vehicle->save();

        ResourceStatus::create([
            'project_id' => $resource->project_id,
            'resource_id' => $resource_id,
            'status' => 'On Delivery',
            'description' => 'Resource is being delivered.',
        ]);

        return redirect()
            ->route('driver.deliveries')
            ->with('success', 'Resource is ready for delivery!');
    }

    public function resource_delivery_complete(Request $request, $resource_id){

        $resource = ProjectResource::findOrFail($resource_id);
        $resource_items = ProjectResourceItem::where('resource_id', $resource_id)->get();

        $resource->update(['status' => 'delivered']);
        foreach($resource_items as $index => $item){
            $item->update(['status' => 'delivered']);
        }

        ResourceStatus::create([
            'project_id' => $resource->project_id,
            'resource_id' => $resource_id,
            'status' => 'Delivered',
            'description' => 'Resource is delivered. Ready for verification.',
        ]);

        return back()
            ->with('success', 'Resource is delivered succesfully!');
    }

    public function resource_verify_complete(Request $request, $resource_id){
        $resource = ProjectResource::findOrFail($resource_id);
        $isIncomplete = false;
        $missingCount = 0;
        $brokenCount = 0;

        foreach ($request->completed as $index => $completed) {
            $resource_item = ProjectResourceItem::findOrFail($index);
            $missing = $request->missing[$index] ?? 0;
            $broken = $request->broken[$index] ?? 0;
            $missingCount += $missing;
            $brokenCount += $broken;

            $expected = $resource_item->quantity;

            if (($completed + $missing + $broken) != $expected) {
                return back()
                    ->withErrors( 'Total quantity did not match.')
                    ->withInput();
            }

            if($completed == $expected){
                $resource_item->status = 'received';
            } else {
                $resource_item->status = 'incomplete';
                $isIncomplete = true;
            }

            $resource_item->completed = $completed;
            $resource_item->missing = $missing;
            $resource_item->broken = $broken;
            $resource_item->save();
        }

        $resource->update(['status' => 'received']);

        if($isIncomplete){
            $descriptions = array_filter([
                $missingCount ? "{$missingCount} items missing" : null,
                $brokenCount ? "{$brokenCount} items broken" : null
            ]);

            ResourceStatus::create([
                'project_id' => $resource->project_id,
                'resource_id' => $resource->id,
                'status' => 'Received With Incompletion',
                'description' => $descriptions 
                    ? implode(' and ', $descriptions) . '.' 
                    : 'Items incomplete',
            ]);
        } else {
            ResourceStatus::create([
                'project_id' => $resource->project_id,
                'resource_id' => $resource->id,
                'status' => 'Received',
                'description' => 'Items are verified and received completely.',
            ]);
        }
        
        return redirect()
            ->route('worker.project.view', $resource->project_id)
            ->with([
                'success' => 'Resource verified successfully.',
                'active_tab' => $resource->id,
            ]);
    }
}
