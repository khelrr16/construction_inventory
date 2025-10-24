<?php

namespace App\Livewire;

use App\Models\Item;
use Livewire\Component;

class SupplyItems extends Component
{
    public string $sortField = 'name';
    public string $sortDirection = 'asc';
    public string $search = '';
    public $warehouse_id;
    public $warehouseId;
    
    protected $queryString = [
        'search' => ['except' => ''],
    ];

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
        $warehouse_items = Item::query()
            ->where('warehouse_id', $this->warehouseId)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
            
        return view('livewire.admin-warehouse-item-table', compact('warehouse_items'));
    }
}