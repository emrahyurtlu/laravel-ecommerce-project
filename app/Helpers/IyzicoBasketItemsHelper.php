<?php

namespace App\Helpers;

use App\Models\Cart;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;

class IyzicoBasketItemsHelper
{
    /**
     * @param Cart $cart
     * @return array
     */
    public static function getBasketItems(Cart $cart): array
    {
        $basketItems = array();
        foreach ($cart->details as $detail) {
            $basketItem = new BasketItem();
            $basketItem->setId($detail->product->product_id);
            $basketItem->setName($detail->product->name);
            $basketItem->setCategory1($detail->product->category->name);
            $basketItem->setItemType(BasketItemType::PHYSICAL);
            $basketItem->setPrice($detail->product->price);

            for ($i = 0; $i < $detail->quantity; $i++) {
                array_push($basketItems, $basketItem);
            }
        }

        return $basketItems;
    }
}
