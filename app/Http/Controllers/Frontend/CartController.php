<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetails;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {

        $cart = $this->getOrCreateCart();

        return view("frontend.user.index", ["cart" => $cart]);
    }

    /**
     * @return Cart
     */
    private function getOrCreateCart(): Cart
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->user_id, 'is_active' => true],
            ['code' => Str::random(8)]
        );
        return $cart;
    }

    public function add(Product $product, int $quantity = 1)
    {
        $cart = $this->getOrCreateCart();
        /*$details = new CartDetails(
            [
                "cart_id" => $cart->cart_id,
                "product_id" => $product->product_id,
                "quantity" => $quantity,
            ]
        );
        $details->save();*/

        $cart->details()->create([
            "product_id" => $product->product_id,
            "quantity" => $quantity,
        ]);


        return redirect("/sepetim");
    }

    public function remove(CartDetails $cartDetails): RedirectResponse
    {
        $cartDetails->delete();
        return redirect("/sepetim");
    }
}
