<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    private static array $userData;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$userData = [
            'name' => "My Test user",
            'email' => "eccount@domain.com",
            'email_verified_at' => now(),
            'password' => "12345",
            'password_confirmation' => "12345",
            'remember_token' => Str::random(10),
            'is_admin' => true,
            'is_active' => true
        ];
    }

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
        $response = $this->post('/users', self::$userData);
        $response->assertRedirect("/users");
    }

    public function test_users_existing_user_is_updated()
    {
        $this->post('/users', self::$userData);
        $user = User::all()->last();
        $user->name = "UPDATED " . $user->name;
        $user->email = "email" . $user->email;
        $data = $user->toArray();
        $response = $this->put('/users/' . $user->user_id, $data);
        $response->assertRedirect("/users");
    }

    public function test_users_latest_user_is_deleted()
    {
        $this->post('/users', self::$userData);
        $user = User::all()->last();
        $user_id = $user->user_id;
        $response = $this->delete('/users/' . $user_id);
        $response->assertJson(["message" => "Done", "id" => $user_id]);
    }
}
