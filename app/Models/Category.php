<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "category_id";

    protected $fillable = [
        "category_id",
        "name",
        "slug",
        "is_active",
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "category_id", "category_id");
    }
}
