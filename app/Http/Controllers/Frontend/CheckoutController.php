<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Shows the payment form
     *
     * @return View
     */
    public function showCheckoutForm(): View
    {
        return view("frontend.cart.checkout_form");
    }

    public function checkout(Request $request): View
    {
        $name = $request->get("name");
        $card_no = $request->get("card_no");
        $expire_month = $request->get("expire_month");
        $expire_year = $request->get("expire_year");
        $cvc = $request->get("cvc");
        dd($name, $card_no, $expire_month, $expire_year, $cvc);

        // Kullanıcıyı al
        // Sepetteki ürünlerin toplam tutarını hesapla
        // PaymentCard Nesnesini oluştur.
        // Buyer nesnesini oluştur
        // Kargo ve fatura adresi nesnelerini oluştur.
        // Sepetteki ürünleri (CartDetails) BasketItem listesi olarak hazırla
        // Ödeme isteği oluştur
        // Ödeme yap
        // İşlem başarılı ise sipariş ve fatura oluştur.
        // İşlem başarılı sayfasına yönlendir.
        // Sandbox panelini kontrol et
    }
}
