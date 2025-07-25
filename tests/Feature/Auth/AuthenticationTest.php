<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_register_user(): void
    {
        $dataUser = [
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ];

        $response = $this->post('/api/register', $dataUser);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['name' => 'user']);
    }
    public function test_login_user(): void
    {
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ]);

        $dataUser = [
            'email' => 'user@mail.com',
            'password' => 'user123',
        ];

        $response = $this->post('/api/login', $dataUser);

        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertNotEmpty($responseData['token']);

    }

    public function test_logout_user()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ]);

        $dataUser = [
            'email' => 'user@mail.com',
            'password' => 'user123',
        ];

        $loginResponse = $this->post('/api/login', $dataUser);
        $token = $loginResponse['token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/logout');

        $response->assertStatus(200);
    }
}
