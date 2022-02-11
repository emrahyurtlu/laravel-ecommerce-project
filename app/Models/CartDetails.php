<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    use HasFactory;

    protected $primaryKey = "card_detail_id";

    protected $fillable = [
        'card_detail_id',
        'card_id',
        'product_id',
        'quantity',
    ];
}
