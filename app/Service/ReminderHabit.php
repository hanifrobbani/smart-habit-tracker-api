<?php
namespace App\Service;
use App\Models\HabitReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\HabitReminderEvent;
use Illuminate\Support\Facades\Log;

class ReminderHabit
{
    public function __invoke()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i');
        $currentDay = $now->format('D');

        $reminders = HabitReminder::with('habit')
            ->whereTime('reminder_time', $currentTime)
            ->where('is_active', true)
            ->get();

        foreach ($reminders as $reminder) {
            $habit = $reminder->habit;

            if (!$habit) {
                continue;
            }

            $shouldSend = false;

            switch ($habit->goal) {
                case 'daily':
                    $shouldSend = true;
                    break;

                case 'weekly':
                    $shouldSend = $now->isMonday();
                    break;

                case 'monthly':
                    $shouldSend = $now->day === 1;
                    break;
            }

            if (!$shouldSend) {
                continue;
            }

            $days = json_decode($reminder->days ?? '[]');

            if (!empty($days) && !in_array($currentDay, $days)) {
                continue;
            }

            $alreadyCheckin = DB::table('habit_checkins')
                ->where('habit_id', $habit->id)
                ->where('user_id', $reminder->user_id)
                ->whereDate('checkin_date', Carbon::today())
                ->exists();

            if (!$alreadyCheckin) {
                event(new HabitReminderEvent($reminder->user_id, $habit->name));
                Log::info("Reminder send for user {$reminder->user_id} - habit {$habit->name}");
            }
        }
    }
}