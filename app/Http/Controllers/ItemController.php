<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemController extends Controller
{
    use SoftDeletes;
    public function index()
    {
        // Make sure you get all items and include the user
        $items = Item::get();

        // Pass $items to the view
        return view('items.index', compact('items'));
    }

    public function clerk_uploadCSV(Request $request, $warehouse_id)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240' // 10MB max
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        $headers = array_shift($csvData); // Remove header row

        $errors = [];
        $successCount = 0;

        foreach ($csvData as $rowIndex => $row) {
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Map CSV columns to database fields
            $data = [
                'warehouse_id' => $warehouse_id,
                'category' => strtolower($row[0]) ?? null,
                'name' => $row[1] ?? null,
                'description' => $row[2] ?? null,
                'cost' => $row[3] ?? null,
                'measure' => $row[4] ?? null,
                'stocks' => $row[5] ?? null,
            ];

            $validator = Validator::make($data, [
                'warehouse_id' => 'required|exists:warehouses,id',
                'category' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'cost' => 'required|numeric|min:0',
                'measure' => 'required|string|max:50',
                'stocks' => 'required|integer|min:0',
            ]);

            if ($validator->fails()) {
                $errors[] = "Row " . ($rowIndex + 2) . ": " . implode(', ', $validator->errors()->all());
                continue;
            }

            try {
                Item::create($data);
                $successCount++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
            }
        }

        $message = "Successfully imported {$successCount} items.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode('; ', $errors);
        }

        return back()->with('success', $message);
    }

    public function clerk_add(Request $request, $warehouse_id)
    {
        $request->validate([
            'category' => 'required|in:tool,material',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'measure' => 'required|string|max:50',
            'stocks' => 'required|integer',
        ]);

        Item::create([
            'warehouse_id' => $warehouse_id,
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'cost' => $request->cost,
            'measure' => $request->measure,
            'stocks' => $request->stocks,
        ]);

        return back()->with('success', 'Item added successfully!');
    }

    public function clerk_update(Request $request, $item_id){
        $item = Item::findOrFail($item_id);

        $request->validate([
            'category' => 'required|in:tool,material',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'required|numeric',
            'measure' => 'required|string|max:50',
            'stocks' => 'required|integer',
        ]);

        $item->update($request->all());

        return redirect()
            ->route('clerk.inventory',$item->warehouse_id)
            ->with('success','Item updated successfuly.');
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('admin.inventory')->with('success', 'Item updated successfully.');
    }
    
    public function batch_supply(Request $request){

        foreach($request->inventory_items as $id => $value){
            $item = Item::findOrFail($id);
            $item->stocks += $value;
            $item->save();
        }

        return back()->with('success', 'Items supplied successfully.');
    }

    public function batch_delete(Request $request){
        $itemCount=0;
        foreach($request->inventory_items as $item_id){
            $item = Item::findOrFail($item_id);
            $item->delete();
            $itemCount++;
        }

        return back()->with('success', 'Succesfully deleted '.$itemCount.' items.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item removed successfully.');
    }
}
