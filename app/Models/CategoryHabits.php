<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryHabits extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'category_habits';

    public function Habits()
    {
        return $this->hasMany(Habit::class, 'id');
    }

}
