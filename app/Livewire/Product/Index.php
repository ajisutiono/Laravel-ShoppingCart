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
    public $formVisible;

    protected $updateQueryString = [
        ['search' => ['except' => '']]
    ];

    protected $listeners = [
        'formClose' => 'formCloseHandler',
        'productStored' => 'productStoredHandler'
    ];
    public function mount()
    {
        $this->search = request('search', $this->search);
    }
    public function render()
    {
        return view('livewire.product.index', [
            'products' => $this->search === null ?
                Product::latest()->paginate($this->paginate) :
                Product::latest()->where('title', 'like', '%' . $this->search . '%')->paginate($this->paginate)
        ]);
    }

    public function formCloseHandler()
    {
        $this->formVisible = false;
    }

    public function productStoredHandler()
    {
        $this->formVisible = false;
        session()->flash("message", "Product created successfully!");
    }
}
