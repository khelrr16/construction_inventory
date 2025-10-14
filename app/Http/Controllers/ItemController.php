<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:tool,material',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric',
            'measure' => 'required|string|max:50',
            'stocks' => 'required|integer',
        ]);

        Item::create([
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'cost' => $request->cost,
            'measure' => $request->measure,
            'stocks' => $request->stocks,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('admin.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('admin.inventory')->with('success', 'Item updated successfully.');
    }
    
    public function batch_supply(Request $request){
        foreach($request->inventory_item as $id => $value){
            $item = Item::findOrFail($id);
            $item->stocks += $value;
            $item->save();
        }

        return back()->with('success', 'Items supplied successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item removed successfully.');
    }
}
