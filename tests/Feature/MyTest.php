<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login success.
     *
     * @return void
     */
    public function test_login_success()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'jannah@gmail.com',
            'password' => Hash::make('12345678'), // Encrypt the password
        ]);

        // Attempt to login
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert success
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'access_token',
                'token_type',
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login failure due to incorrect password.
     *
     * @return void
     */
    public function test_login_failure_incorrect_password()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // Encrypt the password
        ]);

        // Attempt to login with incorrect password
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Assert failure
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized',
            ]);
    }

    /**
     * Test login failure due to validation error.
     *
     * @return void
     */
    public function test_login_failure_validation_error()
    {
        // Attempt to login with invalid data
        $response = $this->postJson('/api/auth/login', [
            'email' => 'not-an-email',
            'password' => '',
        ]);

        // Assert validation error
        $response->assertStatus(400)
            ->assertJsonStructure([
                'email',
                'password',
            ]);
    }
}
