<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Update extends Component
{
    use WithFileUploads;

    public $productId;
    public $title;
    public $price;
    public $description;
    public $image;
    public $imageOld;

    protected $listeners = [
        'editProduct' => 'editProductHandler'
    ];

    // #[On('editProduct')] 


    public function render()
    {
        return view('livewire.product.update');
    }

    public function editProductHandler($product)
    {
        // dd(($product));
        $this->productId = $product['id'];
        $this->title = $product['title'];
        $this->price = $product['price'];
        $this->description = $product['description'];
        $this->imageOld = asset('/storage/images/' . $product['image']);
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'image' => 'image|max:1024'
        ]);

        if ($this->productId) {
            $product = Product::find($this->productId);

            $image = '';

            if ($this->image) {
                Storage::disk('public')->delete('/images/'.$product->image);

                $imageName = Str::slug($this->title, '-')
                    . '-'
                    . uniqid()
                    . '.' . $this->image->getClientOriginalExtension();

                $this->image->storeAs('images', $imageName, 'public');

                $image = $imageName;
            } else {
                $image = $product->image;
            }

            $product->update([
                'title' => $this->title,
                'price' => $this->price,
                'description' => $this->description,
                'image' => $image
            ]);

            $this->dispatch('productUpdated');
        }
    }
}
