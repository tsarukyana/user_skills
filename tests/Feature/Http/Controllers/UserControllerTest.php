<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_have_description()
    {
        // Create 10 users
        User::factory()->count(10)->create();

        // Fetch the first page of users (3 per page)
        $response = $this->get('/users');

        $response->assertStatus(200);

        // Check that we have received 3 users
        $this->assertCount(3, $response->json('data'));

        // Fetch the second page of users
        $response = $this->get('/users?page=2');

        $response->assertStatus(200);

        // Check that we have received 3 users on the second page
        $this->assertCount(3, $response->json('data'));

        // Fetch the third page of users
        $response = $this->get('/users?page=3');

        $response->assertStatus(200);

        // Check that we have received 3 users on the third page
        $this->assertCount(3, $response->json('data'));

        // Fetch the fourth page of users (last page will have 1 user)
        $response = $this->get('/users?page=4');

        $response->assertStatus(200);

        // Check that we have received 1 user on the fourth page
        $this->assertCount(1, $response->json('data'));

        // Check that all users have a non-empty description
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            $this->assertNotEmpty($user->description);
        }
    }

    public function test_store_user_with_valid_alpha_name()
    {
        $userData = [
            'name' => 'JohnDoe',
            'email' => 'alpha@example.com'
        ];

        $response = $this->postJson('/users', $userData);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => 'JohnDoe']);
        $response->assertJsonFragment(['email' => 'alpha@example.com']);
        $this->assertNotEmpty($response->json('description'));
    }

    public function test_store_user_with_invalid_name()
    {
        $invalidUserData = [
            'name' => 'John Doe', // Invalid name (contains space)
            'email' => 'johndoe@example.com'
        ];

        $response = $this->postJson('/users', $invalidUserData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function test_store_user_with_invalid_email()
    {
        $invalidUserData = [
            'name' => 'JohnDoe123',
            'email' => 'not-an-email' // Invalid email
        ];

        $response = $this->postJson('/users', $invalidUserData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_store_user_with_valid_numeric_name()
    {
        $userData = [
            'name' => '1234567890',
            'email' => 'numeric@example.com'
        ];

        $response = $this->postJson('/users', $userData);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => '1234567890']);
        $response->assertJsonFragment(['email' => 'numeric@example.com']);
        $this->assertNotEmpty($response->json('description'));
    }

    public function test_store_user_with_invalid_mixed_name()
    {
        $invalidUserData = [
            'name' => 'JohnDoe123', // Invalid name (mix of letters and numbers)
            'email' => 'mixed@example.com'
        ];

        $response = $this->postJson('/users', $invalidUserData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function test_store_user_with_invalid_special_characters()
    {
        $invalidUserData = [
            'name' => 'John_Doe', // Invalid name (contains special character)
            'email' => 'special@example.com'
        ];

        $response = $this->postJson('/users', $invalidUserData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function test_store_user_with_invalid_long_name()
    {
        $invalidUserData = [
            'name' => 'ThisIsAVeryLongNameExceedingNeededCountOfChars', // Invalid name (more than 12 characters)
            'email' => 'long@example.com'
        ];

        $response = $this->postJson('/users', $invalidUserData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }
}
