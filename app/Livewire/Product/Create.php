<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Create extends Component
{
    public $title;
    public $price;
    public $description;

    public function render()
    {
        return view('livewire.product.create');
    }

    public function store() {

        $this->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        $product = [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            
        ];

        Product::create($product);
        $this->dispatch('productStored');
    }
}
