<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CreditCard;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Payment;
use Iyzipay\Model\PaymentCard;
use Iyzipay\Model\PaymentChannel;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreatePaymentRequest;

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
        $request = new CreatePaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($cart->code);
        $request->setPrice($total);
        $request->setPaidPrice($total);
        $request->setCurrency(Currency::TL);
        $request->setInstallment(1);
        $request->setBasketId($cart->code);
        $request->setPaymentChannel(PaymentChannel::WEB);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);

        // PaymentCard Nesnesini oluştur.
        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($name);
        $paymentCard->setCardNumber($card_no);
        $paymentCard->setExpireMonth($expire_month);
        $paymentCard->setExpireYear($expire_year);
        $paymentCard->setCvc($cvc);
        $paymentCard->setRegisterCard(0);
        $request->setPaymentCard($paymentCard);

        // Buyer nesnesini oluştur
        $buyer = new Buyer();
        $buyer->setId($user->user_id);
        $buyer->setName($user->name);
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp(\request()->ip());
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);

        // Kargo adresi nesnelerini oluştur.
        $shippingAddress = new Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);

        // Fatura adresi nesnelerini oluştur.
        $billingAddress = new Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);

        // Sepetteki ürünleri (CartDetails) BasketItem listesi olarak hazırla
        $basketItems = $this->getBasketItems();
        $request->setBasketItems($basketItems);

        //Options Nesnesi Oluştur
        $options = new Options();
        $options->setApiKey(env("TEST_IYZI_API_KEY"));
        $options->setSecretKey(env("TEST_IYZI_SECRET_KEY"));
        $options->setBaseUrl(env("TEST_IYZI_BASE_URL"));

        // Ödeme yap
        $payment = Payment::create($request, $options);

        // İşlem başarılı ise sipariş ve fatura oluştur.
        if ($payment->getStatus() == "success") {

            // Sepeti sona erdir.
            $cart->is_active = false;
            $cart->save();

            // Sipariş oluştur
            $order = new Order([
                "cart_id" => $cart->cart_id,
                "code" => $cart->code
            ]);
            $order->save();

            // Sipariş detaylarını oluştur
            $order->details()->create($cart->details);

            //Fatura Oluştur
            $invoice = new Invoice([
                "cart_id" => $order->order_id,
                "code" => $order->code
            ]);

            //Fatura detaylarını oluştur
            $invoice->details()->create($order->details);


            return view("frontend.checkout.success");

        } else {
            $errorMessage = $payment->getErrorMessage();
            return view("frontend.checkout.error", ["message" => $errorMessage]);
        }
    }

    /**
     * @return float
     */
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

    /**
     * @return array
     */
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

    private function createOrderWithDetails(Cart $cart): Order
    {
        $order = new Order([
            "cart_id" => $cart->cart_id,
            "code" => $cart->code
        ]);
        $order->save();

        $order->details()->create($cart->details);

        return $order;
    }

    private function createInvoiceWithDetails(Order $order)
    {
        $invoice = new Invoice([
            "cart_id" => $order->order_id,
            "code" => $order->code
        ]);

        //Fatura Detaylarını Ekle
        $invoice->details()->create($order->details);
    }

    private function finalizeCart(Cart $cart)
    {
        $cart->is_active = false;
        $cart->save();
    }
}
