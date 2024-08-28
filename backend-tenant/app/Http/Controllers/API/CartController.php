<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $product = Product::find($request->product_id);
        $price = $product->price;
        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => $request->quantity, 'price' => $price]
        );

        $cart->total_price = $cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return response()->json($cart->load('items'), 201);
    }

    public function viewCart()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();
        return response()->json($cart);
    }

    public function updateCartItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->update(['quantity' => $request->quantity]);

        $cart = $cartItem->cart;
        $cart->total_price = $cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return response()->json($cart->load('items'));
    }

    public function removeCartItem($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->delete();

        $cart = $cartItem->cart;
        $cart->total_price = $cart->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $cart->save();

        return response()->json($cart->load('items'));
    }

    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Implement the checkout logic, e.g., creating orders, reducing stock, etc.

        $cart->delete(); // Clear the cart after checkout
        return response()->json(['message' => 'Checkout successful']);
    }
}
