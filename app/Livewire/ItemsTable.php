<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\ProjectResource;
use App\Models\ProjectResourceItem;

class ItemsTable extends Component
{
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public string $search = '';
    public $resource_id;
    public $selectedItems = [];
    
    public $isAdding = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->selectedItems = [];
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleItem($itemId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            // Remove item if already selected
            $this->selectedItems = array_values(array_diff($this->selectedItems, [$itemId]));
        } else {
            // Add item if not selected
            $this->selectedItems[] = $itemId;
        }
    }

    public function isSelected($itemId)
    {
        return in_array($itemId, $this->selectedItems);
    }

    public function clearSelections()
    {
        $this->selectedItems = [];
    }

    public function addItemsToResource($resource_id){
        if ($this->isAdding) {
            return;
        }

        $this->isAdding = true;

        $resource = ProjectResource::findOrFail($resource_id);
        
        foreach ($this->selectedItems as $item_id) {
            ProjectResourceItem::create([
                'project_id' => $resource->project_id,
                'resource_id' => $resource->id,
                'item_id'    => $item_id,
                'quantity'   => 1,
                'status' => 'draft',
            ]);
        }

        return redirect()
            ->route('worker.resource.edit', $resource->id)
            ->with(['success' =>'Items added successfully!']);
    }

    public function render()
    {
        $resource = ProjectResource::with([
            'items',
            'project',
        ])->findOrFail($this->resource_id);

        $usedItemIds = $resource->items->pluck('item_id');
        
        $items = Item::query()
            ->whereNotIn('id', $usedItemIds)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        // Get the selected items as Item models for the modal
        $selectedItemModels = [];
        if (!empty($this->selectedItems)) {
            $selectedItemModels = Item::whereIn('id', $this->selectedItems)->get();
        }

        return view('livewire.worker-item-table', [
            'items' => $items,
            'selectedItemModels' => $selectedItemModels,
            'resource' => $resource
        ]);
    }
}