<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $paginate = 10;
    public $search;
    public $formVisible = false;
    public $formUpdate = false;

    protected $updateQueryString = [
        ['search' => ['except' => '']]
    ];

    protected $listeners = [
        'formClose' => 'formCloseHandler',
        'productStored' => 'productStoredHandler',
        'productUpdated' => 'productUpdatedHandler'
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

    public function editProduct ($productId)
    {
        $this->formUpdate = true;
        $this->formVisible = true;
        $product = Product::find($productId);
        $this->dispatch('editProduct', $product)->to(Update::class);
    }

    public function productUpdatedHandler ()
    {
        $this->formVisible = false;
        session()->flash('message', 'Product updated successfully');
    }

    public function deleteProduct($productId) 
    {
        $product = Product::find($productId);
        
        if ($product->image) {
            Storage::disk('public')->delete('/images/'.$product->image);
        }

        $product->delete();
        session()->flash('message', 'Product deleted successfully');
    }
}
