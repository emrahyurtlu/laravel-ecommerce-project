<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_index_status()
    {
        $response = $this->get('/users');
        $response->assertOk();
    }

    public function test_users_index_url_goes_to_correct_view()
    {
        $response = $this->get('/users');
        $response->assertViewIs("backend.users.index");
    }

    public function test_users_create_status()
    {
        $response = $this->get('/users/create');
        $response->assertOk();
    }

    public function test_users_create_url_goes_to_correct_view()
    {
        $response = $this->get('/users/create');
        $response->assertViewIs("backend.users.insert_form");
    }

    public function test_users_new_user_id_created()
    {
        $user = User::factory()->count(1)->create();
        $data = $user->toArray();
        $response = $this->post('/users', $data);
        $response->assertRedirect("/users");
    }

    public function test_users_existing_user_is_updated()
    {
        $user = User::latest()->first();
        $user->name = "UPDATED " . $user->name;
        $user->email = "email" . $user->email;
        $data = $user->toArray();
        $response = $this->put('/users/' . $user->user_id, $data);
        $response->assertRedirect("/users");
    }

    public function test_users_latest_user_is_deleted()
    {
        $user = User::latest()->first();
        $user_id = $user->user_id;
        $response = $this->delete('/users/' . $user_id);
        $response->assertOk();
        $response->assertJson(["message" => "Done", "id" => $user_id]);
    }
}
