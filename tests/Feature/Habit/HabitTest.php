<?php

namespace Tests\Feature\Habit;

use App\Models\CategoryHabits;
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

    public function test_post_data_habit()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ]);
        CategoryHabits::create([
            'id' => 1,
            'name' => 'health',
        ]);

        $dataUser = [
            'email' => 'user@mail.com',
            'password' => 'user123',
        ];
        $dataHabit = [
            'name' => 'eat healthy',
            'categories_id' => '1',
            'user_id' => '1',
            'goal' => 'daily',
        ];

        $loginResponse = $this->post('/api/login', $dataUser);
        $token = $loginResponse['token'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/habits', $dataHabit);

        $this->assertDatabaseHas('habits', ['name' => 'eat healthy']);
        $response->assertStatus(201);
    }
    public function test_update_data_habit()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ]);
        CategoryHabits::create([
            'id' => 1,
            'name' => 'health',
        ]);

        $dataUser = [
            'email' => 'user@mail.com',
            'password' => 'user123',
        ];

        $loginResponse = $this->post('/api/login', $dataUser);
        $token = $loginResponse['token'];

        $dataHabit = [
            'name' => 'eat healthy',
            'categories_id' => 1,
            'user_id' => 1,
            'goal' => 'daily',
        ];

        $createResponse = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/habits', $dataHabit);

        $createResponse->assertStatus(201);
        $habitId = $createResponse['data']['id'];

        $updatedHabit = [
            'name' => 'gym',
            'categories_id' => 1,
            'goal' => 'weekly',
        ];

        $updateResponse = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->put("/api/habits/{$habitId}", $updatedHabit);

        $updateResponse->assertStatus(200);

        $this->assertDatabaseHas('habits', [
            'id' => $habitId,
            'name' => 'gym',
            'goal' => 'weekly',
        ]);

        $this->assertDatabaseMissing('habits', [
            'id' => $habitId,
            'name' => 'eat healthy',
        ]);
    }

    public function test_delete_data_habit()
    {
        User::create([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ]);
        CategoryHabits::create([
            'id' => 1,
            'name' => 'health',
        ]);

        $dataUser = [
            'email' => 'user@mail.com',
            'password' => 'user123',
        ];

        $loginResponse = $this->post('/api/login', $dataUser);
        $token = $loginResponse['token'];

        $dataHabit = [
            'name' => 'eat healthy',
            'categories_id' => 1,
            'user_id' => 1,
            'goal' => 'daily',
        ];

        $createResponse = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/habits', $dataHabit);

        $createResponse->assertStatus(201);
        $habitId = $createResponse['data']['id'];

        $deleteResponse = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->delete("/api/habits/{$habitId}");
        $deleteResponse->assertStatus(200);

        $this->assertDatabaseMissing('habits', [
            'id' => $habitId,
            'name' => 'eat healthy',
        ]);
    }

}
