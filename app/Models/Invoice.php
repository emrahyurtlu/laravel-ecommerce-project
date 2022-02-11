<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "invoice_id";

    protected $fillable = [
        'invoice_id',
        'order_id',
        'code',
    ];
}
