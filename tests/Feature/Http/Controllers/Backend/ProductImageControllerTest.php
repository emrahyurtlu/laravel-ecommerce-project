<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_page_status()
    {
        $response = $this->get('/products/1/images');
        $response->assertStatus(200);
    }

    public function test_index_url_goes_to_correct_view()
    {
        $response = $this->get('/products/1/images');
        $response->assertViewIs("backend.images.index");
    }

    public function test_address_create_form_page_status()
    {
        $response = $this->get('/products/1/images/create');
        $response->assertOk();
    }

    public function test_products_create_form_goes_to_correct_view()
    {
        $response = $this->get('/products/1/images/create');
        $response->assertViewIs("backend.images.insert_form");
    }

    public function test_new_resource_is_created()
    {
        $image = UploadedFile::fake()->image('product.jpg');
        $data = [
            "product_id" => 1,
            "image_url" => $image,
            "alt" => "Test alt alanı",
            "seq" => 222
        ];


        $response = $this->post('/products/1/images', $data);

        $response->assertRedirect("/products/1/images");

        Storage::disk('local')->assertExists("public/products/" . $image->hashName());
    }

    public function test_existing_resource_is_updated()
    {
        $entity = ProductImage::all()->last();
        $entity->city = "EDITED: " . $entity->alt;

        $id = $entity->image_id;
        $data = $entity->toArray();

        $image = UploadedFile::fake()->image('product.jpg');
        $data["image_url"] = $image;

        $response = $this->put('/products/1/images/' . $id, $data);
        $response->assertRedirect("/products/1/images");
    }

    public function test_latest_resource_is_deleted()
    {
        $entity = ProductImage::all()->last();
        $id = $entity->image_id;
        $response = $this->delete('/products/1/images/' . $id);
        $response->assertJson(["message" => "Done", "id" => $id]);
    }
}
