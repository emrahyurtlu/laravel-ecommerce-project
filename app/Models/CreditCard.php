<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "card_no",
        "expire_month",
        "expire_year",
        "cvc",
    ];

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCardNo()
    {
        return $this->card_no;
    }

    /**
     * @param mixed $card_no
     */
    public function setCardNo($card_no): void
    {
        $this->card_no = $card_no;
    }

    /**
     * @return mixed
     */
    public function getExpireMonth()
    {
        return $this->expire_month;
    }

    /**
     * @param mixed $expire_month
     */
    public function setExpireMonth($expire_month): void
    {
        $this->expire_month = $expire_month;
    }

    /**
     * @return mixed
     */
    public function getExpireYear()
    {
        return $this->expire_year;
    }

    /**
     * @param mixed $expire_year
     */
    public function setExpireYear($expire_year): void
    {
        $this->expire_year = $expire_year;
    }

    /**
     * @return mixed
     */
    public function getCvc()
    {
        return $this->cvc;
    }

    /**
     * @param mixed $cvc
     */
    public function setCvc($cvc): void
    {
        $this->cvc = $cvc;
    }


}
