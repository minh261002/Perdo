<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subTotal = $cart ? array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart)) : 0;
        $totalPrice = $subTotal;
        return view('client.checkout.index', compact('cart', 'subTotal', 'totalPrice'));
    }
}