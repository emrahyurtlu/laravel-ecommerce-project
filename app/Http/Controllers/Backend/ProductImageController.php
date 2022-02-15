<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function __construct()
    {
        $this->returnUrl = "/products/{}/images";
        $this->fileRepo = "public/products";
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Product $product): View
    {
        return view("backend.images.index", ["product" => $product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Product $product): View
    {
        return view("backend.images.insert_form", ["product" => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Product $product
     * @param ProductImageRequest $request
     * @return RedirectResponse
     */
    public function store(ProductImageRequest $request, Product $product): RedirectResponse
    {
        $productImage = new ProductImage();
        $data = $this->prepare($request, $productImage->getFillable());
        $productImage->fill($data);
        $productImage->save();

        $this->editReturnUrl($product->product_id);

        return Redirect::to($this->returnUrl);
    }

    private function editReturnUrl($id)
    {
        $this->returnUrl = "/products/$id/images";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param ProductImage $image
     * @return View
     */
    public function edit(Product $product, ProductImage $image): View
    {
        return view("backend.images.update_form", ["product" => $product, "image" => $image]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductImageRequest $request
     * @param Product $product
     * @param ProductImage $image
     * @return RedirectResponse
     */
    public function update(ProductImageRequest $request, Product $product, ProductImage $image): RedirectResponse
    {
        $data = $this->prepare($request, $image->getFillable());
        $image->fill($data);
        $image->save();

        $this->editReturnUrl($product->product_id);

        return Redirect::to($this->returnUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param ProductImage $image
     * @return JsonResponse
     */
    public function destroy(Product $product, ProductImage $image): JsonResponse
    {
        $image->delete();
        $filepath = $this->fileRepo . "/" . $image->image_url;

        if (Storage::disk("local")->exists($filepath)) {
            Storage::disk("local")->delete($filepath);
        }

        return response()->json(["message" => "Done", "id" => $image->image_id]);
    }
}
