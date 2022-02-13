<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate([
            'user_id' => $user->user_id,
            'code' => Str::random(8)
        ]);
        return view("frontend.user.index", ["cart" => $cart]);
    }
}
