<?php

namespace App\Helpers;

use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Iyzipay\Model\Buyer;
use function request;

class IyzicoBuyerHelper
{
    /**
     * @param Address $addr
     * @return Buyer
     */
    public static function getBuyer(): Buyer
    {
        $user = Auth::user();
        $addr = $user->addrs[0];
        $buyer = new Buyer();
        $buyer->setId($user->user_id);
        $buyer->setName($user->name);
        $buyer->setSurname("Akan");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate(Carbon::parse(now())->format("Y-m-d h:i:s"));
        $buyer->setRegistrationDate(Carbon::parse($user->created_at)->format("Y-m-d h:i:s"));
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp(request()->ip());
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");

        return $buyer;
    }
}
