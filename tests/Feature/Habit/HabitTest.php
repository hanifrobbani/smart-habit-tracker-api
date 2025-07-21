<?php

namespace Tests\Feature\Habit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HabitTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_get_data_habit(): void
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

        $response = $this->get('/api/habits', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200);
    }
}
