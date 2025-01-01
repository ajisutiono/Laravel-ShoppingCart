<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $price;
    public $description;
    public $image;

    public function render()
    {
        return view('livewire.product.create');
    }

    public function store() {
        
        $this->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'image|max:1024'
        ]);

        $imageName = '';

        if ($this->image) {
            $imageName = Str::slug($this->title, '-')
                . '-'
                . uniqid()
                . '.' . $this->image->getClientOriginalExtension();

            $this->image->storeAs('public', $imageName, 'local');
        }

        $product = [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imageName
            
        ];

        Product::create($product);
        $this->dispatch('productStored');
    }
}
