<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\IyzicoAddressHelper;
use App\Helpers\IyzicoBuyerHelper;
use App\Helpers\IyzicoOptionsHelper;
use App\Helpers\IyzicoPaymentCardHelper;
use App\Helpers\IyzicoRequestHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CreditCard;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Payment;

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
        $creditCard = new CreditCard();
        $data = $this->prepare($request, $creditCard->getFillable());
        $creditCard->fill($data);

        // Kullanıcıyı al
        $user = Auth::user();

        // Sepetteki ürünlerin toplam tutarını hesapla
        $total = $this->calculateCartTotal();

        // Sepeti getir
        $cart = $this->getOrCreateCart();


        // Ödeme isteği oluştur
        $request = IyzicoRequestHelper::createRequest($cart, $total);

        // PaymentCard Nesnesini oluştur.
        $paymentCard = IyzicoPaymentCardHelper::getPaymentCard($creditCard);
        $request->setPaymentCard($paymentCard);

        // Buyer nesnesini oluştur
        $buyer = IyzicoBuyerHelper::getBuyer();
        $request->setBuyer($buyer);

        // Kargo adresi nesnelerini oluştur.
        $shippingAddress = IyzicoAddressHelper::getAddress();
        $request->setShippingAddress($shippingAddress);

        // Fatura adresi nesnelerini oluştur.
        $billingAddress = IyzicoAddressHelper::getAddress();
        $request->setBillingAddress($billingAddress);

        // Sepetteki ürünleri (CartDetails) BasketItem listesi olarak hazırla
        $basketItems = $this->getBasketItems();
        $request->setBasketItems($basketItems);

        //Options Nesnesi Oluştur
        $options = IyzicoOptionsHelper::getTestOptions();

        // Ödeme yap
        $payment = Payment::create($request, $options);

        // İşlem başarılı ise sipariş ve fatura oluştur.
        if ($payment->getStatus() == "success") {

            // Sepeti sona erdir.
            $this->finalizeCart($cart);

            // Sipariş oluştur
            $order = $this->createOrderWithDetails($cart);

            //Fatura Oluştur
            $this->createInvoiceWithDetails($order);

            return view("frontend.checkout.success");

        } else {
            $errorMessage = $payment->getErrorMessage();
            return view("frontend.checkout.error", ["message" => $errorMessage]);
        }
    }

    private function calculateCartTotal(): float
    {
        $total = 0;
        $cart = $this->getOrCreateCart();
        $cartDetails = $cart->details;
        foreach ($cartDetails as $detail) {
            $total += $detail->product->price * $detail->quantity;
        }

        return $total;
    }

    private function getOrCreateCart(): Cart
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->user_id, 'is_active' => true],
            ['code' => Str::random(8)]
        );
        return $cart;
    }

    private function getBasketItems(): array
    {
        $basketItems = array();
        $cart = $this->getOrCreateCart();
        $cartDetails = $cart->details;

        foreach ($cartDetails as $detail) {
            $item = new BasketItem();
            $item->setId($detail->product->product_id);
            $item->setName($detail->product->name);
            $item->setCategory1($detail->product->category->name);
            $item->setItemType(BasketItemType::PHYSICAL);
            $item->setPrice($detail->product->price);

            for ($i = 0; $i < $detail->quantity; $i++) {
                array_push($basketItems, $item);
            }
        }

        return $basketItems;
    }

    private function finalizeCart(Cart $cart)
    {
        $cart->is_active = false;
        $cart->save();
    }

    private function createOrderWithDetails(Cart $cart): Order
    {
        $order = new Order([
            "cart_id" => $cart->cart_id,
            "code" => $cart->code
        ]);
        $order->save();

        foreach ($cart->details as $detail) {
            $order->details()->create([
                'order_id' => $order->order_id,
                'product_id' => $detail->product_id,
                'quantity' => $detail->quantity
            ]);
        }

        return $order;
    }

    private function createInvoiceWithDetails(Order $order)
    {
        $invoice = new Invoice([
            "cart_id" => $order->order_id,
            "code" => $order->code
        ]);

        //Fatura Detaylarını Ekle
        foreach ($order->details as $detail) {
            $invoice->details()->create([
                'invoice_id' => $invoice->invoice_id,
                'product_id' => $detail->product_id,
                'quantity' => $detail->quantity,
                'unit_price' => $detail->product->price,
                'total' => ($detail->quantity * $detail->product->price),
            ]);
        }

    }
}
