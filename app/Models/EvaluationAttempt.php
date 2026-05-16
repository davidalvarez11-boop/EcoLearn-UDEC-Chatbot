<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAttempt extends Model
{
    protected $fillable = ['user_id', 'course_id', 'answers', 'score', 'total'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function percentage(): int
    {
        if ($this->total === 0) return 0;
        return (int) round(($this->score / $this->total) * 100);
    }

    public function passed(): bool
    {
        return $this->percentage() >= 60;
    }
}
