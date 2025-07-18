<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitCheckins extends Model
{
    protected $guarded = [];
    protected $table = 'habit_checkins';

    public function habit()
    {
        return $this->belongsTo(Habit::class, 'habit_id');
    }

}
