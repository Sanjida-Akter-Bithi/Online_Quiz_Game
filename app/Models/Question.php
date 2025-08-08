<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned
    protected $fillable = [
        'quiz_id',
        'question_text',
    ];

    /**
     * Get the quiz this question belongs to.
     */
    public function quiz()
    {
        return $this->belongsTo(\App\Models\Quiz::class);
    }

    /**
     * Get the options for this question.
     */
    public function options()
    {
        return $this->hasMany(\App\Models\Option::class);
    }
}
