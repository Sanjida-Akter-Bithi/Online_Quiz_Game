<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['title', 'description', 'category_id', 'difficulty'];

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
