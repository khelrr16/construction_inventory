<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;
use App\Models\ProjectResource;

class ItemsTable extends Component
{
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public string $search = '';
    public $resource_id;
    public $selectedItems = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->selectedItems = [];
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

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
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