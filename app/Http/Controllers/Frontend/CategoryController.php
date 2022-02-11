<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Category $category): View
    {
        $products = $category->products;
        $allCategories = Category::all()->where("is_active", true);

        return view("frontend.home.index", ["categories" => $allCategories, "products" => $products]);
    }
}
