<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $guarded = [];
    protected $table = 'habits';

    public function habitCategory()
    {
        return $this->belongsTo(CategoryHabits::class, 'categories_id');
    }
}
