<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    //use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_resource_index_page_status()
    {
        $response = $this->get('/products');
        $response->assertOk();
    }

    public function test_resource_index_url_goes_to_correct_view()
    {
        $response = $this->get('/products');
        $response->assertViewIs("backend.products.index");
    }

    public function test_resource_create_form_page_status()
    {
        $response = $this->get('/products/create');
        $response->assertOk();
    }

    public function test_resource_create_form_goes_to_correct_view()
    {
        $response = $this->get('/products/create');
        $response->assertViewIs("backend.products.insert_form");
    }


    public function test_resource_new_resource_is_created()
    {
        $suffix = Str::random();
        $data = [
            "category_id" => 444,
            "name" => "Deneme Ürünü -" . $suffix,
            "price" => 67.12,
            "lead" => "Bu alan kısa açıklama alanıdır"
        ];

        $response = $this->post('/products', $data);
        $response->assertRedirect("/products");
    }

    public function test_resource_new_resource_is_created_with_optinal_fields()
    {
        $suffix = Str::random();
        $data = [
            "category_id" => 444,
            "name" => "İndirimli Ürünü -" . $suffix,
            "price" => 67.12,
            "old_price" => 97.12,
            "lead" => "Bu alan kısa açıklama alanıdır"
        ];

        $response = $this->post('/products', $data);
        $response->assertRedirect("/products");
    }

    public function test_resource_existing_user_is_updated()
    {
        $entity = Product::all()->last();
        $entity->name = "UPDATED " . $entity->name;
        $entity->slug = "UPDATED " . $entity->slug;
        $data = $entity->toArray();
        $response = $this->put('/products/' . $entity->product_id, $data);
        $response->assertRedirect("/products");
    }

    public function test_resource_latest_user_is_deleted()
    {
        $entity = Product::all()->last();
        $id = $entity->product_id;
        $response = $this->delete('/products/' . $id);
        $response->assertJson(["message" => "Done", "id" => $id]);
    }
}
