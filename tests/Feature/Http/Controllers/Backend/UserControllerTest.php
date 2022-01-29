<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    //use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_index_page_status()
    {
        $response = $this->get('/users');
        $response->assertOk();
    }

    public function test_users_index_url_goes_to_correct_view()
    {
        $response = $this->get('/users');
        $response->assertViewIs("backend.users.index");
    }

    public function test_users_create_form_page_status()
    {
        $response = $this->get('/users/create');
        $response->assertOk();
    }

    public function test_users_create_form_goes_to_correct_view()
    {
        $response = $this->get('/users/create');
        $response->assertViewIs("backend.users.insert_form");
    }


    public function test_users_new_resource_is_created()
    {
        $user = User::factory()->make();
        $data = $user->toArray();
        $data["password"] = "12345";
        $data["password_confirmation"] = "12345";

        $response = $this->post('/users', $data);
        $response->assertRedirect("/users");
    }

    public function test_users_existing_user_is_updated()
    {
        $user = User::all()->last();
        $user->name = "UPDATED " . $user->name;
        $user->email = "email" . $user->email;
        $data = $user->toArray();
        $response = $this->put('/users/' . $user->user_id, $data);
        $response->assertRedirect("/users");
    }

    public function test_users_latest_user_is_deleted()
    {
        $user = User::all()->last();
        $user_id = $user->user_id;
        $response = $this->delete('/users/' . $user_id);
        $response->assertOk();
        $response->assertJson(["message" => "Done", "id" => $user_id]);
        $this->assertDeleted($user);
    }
}
