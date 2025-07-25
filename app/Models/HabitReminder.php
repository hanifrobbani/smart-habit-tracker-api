<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitReminder extends Model
{
    protected $guarded = [];
    protected $table = 'habit_reminders';

    public function habit(){
        return $this->hasMany(Habit::class, 'habit_id');
    }
}
