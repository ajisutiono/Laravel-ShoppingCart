<?php

namespace App\Livewire\Shop;

use App\Facades\Cart;
use Livewire\Component;

class Cartnav extends Component
{
    public $cartTotal = 0;

    public $listeners = [
        'addToCart' => 'updateCartTotal'
    ];

    public function mount()
    {
        $this->updateCartTotal();
    }

    public function render()
    {
        return view('livewire.shop.cartnav');
    }

    public function updateCartTotal()
    {
        $this->cartTotal = count(Cart::get()['products']);
    }
}
