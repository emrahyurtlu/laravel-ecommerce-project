<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    //use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_resource_index_page_status()
    {
        $response = $this->get('/categories');
        $response->assertOk();
    }

    public function test_resource_index_url_goes_to_correct_view()
    {
        $response = $this->get('/categories');
        $response->assertViewIs("backend.categories.index");
    }

    public function test_resource_create_form_page_status()
    {
        $response = $this->get('/categories/create');
        $response->assertOk();
    }

    public function test_resource_create_form_goes_to_correct_view()
    {
        $response = $this->get('/categories/create');
        $response->assertViewIs("backend.categories.insert_form");
    }


    public function test_resource_new_resource_is_created()
    {
        $suffix = Str::random();
        $data = [
            "name" => "Deneme kategorisi-".$suffix,
            "slug" => "deneme-kategorisi-".$suffix
        ];

        $response = $this->post('/categories', $data);
        $response->assertRedirect("/categories");
    }

    public function test_resource_existing_user_is_updated()
    {
        $entity = Category::all()->last();
        $entity->name = "UPDATED " . $entity->name;
        $entity->slug = "UPDATED " . $entity->slug;
        $data = $entity->toArray();
        $response = $this->put('/categories/' . $entity->category_id, $data);
        $response->assertRedirect("/categories");
    }

    public function test_resource_latest_user_is_deleted()
    {
        $entity = Category::all()->last();
        $id = $entity->category_id;
        $response = $this->delete('/categories/' . $id);
        $response->assertJson(["message" => "Done", "id" => $id]);
    }
}
