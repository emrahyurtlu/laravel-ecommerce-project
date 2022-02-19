<?php

namespace App\Helpers;

use Iyzipay\Model\Address;

class IyzicoAddressHelper
{
    /**
     * @return Address
     */
    public static function getAddress(): Address
    {
        $address = new Address();
        $address->setContactName("Jane Doe");
        $address->setCity("Istanbul");
        $address->setCountry("Turkey");
        $address->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $address->setZipCode("34742");
        return $address;
    }
}
