<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $paginate = 10;
    public $search;

    protected $updateQueryString = [
        ['search' => ['except' => '']]
    ];

    public function mount() {
        $this->search = request('search', $this->search);
    }
    public function render()
    {
        return view('livewire.product.index', [
            'products' => $this->search === null ?
            Product::latest()->paginate($this->paginate) :
            Product::latest()->where('title', 'like', '%'. $this->search . '%')->paginate($this->paginate)
        ]);
    }
}
