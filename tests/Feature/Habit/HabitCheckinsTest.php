<?php

namespace Tests\Feature\Habit;

use App\Models\CategoryHabits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HabitCheckinsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_checkin_habit(): void
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
        $userId = $loginResponse['user']['id'];

        $dataHabit = [
            'name' => 'eat healthy',
            'categories_id' => 1,
            'user_id' => 1,
            'goal' => 'daily',
        ];

        $createHabit = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post('/api/habits', $dataHabit);

        $habitId = $createHabit['data']['id'];
        $checkInHabit = [
            'habit_id' => $habitId,
            'user_id' => $userId,
            'checkin_date' => Carbon::now(),
        ];

        $checkResponse = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->post("api/habit/{$habitId}/check", $checkInHabit);

        $checkResponse->assertStatus(200);
        $this->assertDatabaseHas('habit_checkins', [
            'habit_id' => $habitId,
            'user_id' => $userId,
        ]);
    }
}
