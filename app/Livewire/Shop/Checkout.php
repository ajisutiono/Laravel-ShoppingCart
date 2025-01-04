<?php

namespace App\Livewire\Shop;

use App\Facades\Cart;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
use Livewire\Attributes\On;

class Checkout extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $address;
    public $city;
    public $postal_code;
    public $formCheckout;
    public $snapToken;

    public function mount()
    {
        $this->formCheckout = true;
    }
    public $listeners = [
        'emptyCart' => 'emptyCartHandler'
    ];

    // #[On('emptyCart')]

    public function render()
    {
        return view('livewire.shop.checkout');
    }

    public function checkout()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required'
        ]);

        $cart = Cart::get()['products'];
        $amount = array_sum(
            array_column($cart, 'price')
        );

        $customerDetails = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
        ];

        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $amount
        ];

        $payload = [
            'customer_details' => $customerDetails,
            'transaction_details' => $transactionDetails
        ];

        $this->formCheckout = false;

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $snapToken = \Midtrans\Snap::getSnapToken($payload);

        $this->snapToken = $snapToken;
    }

    public function emptyCartHandler()
    {
        Cart::clear();
        $this->dispatch('cartClear');
    }
}
