<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EvaluationAttempt;

class ProgressController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $attempts = EvaluationAttempt::with('course')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $totalCourses   = Course::count();
        $coursesEvaluated = $attempts->pluck('course_id')->unique()->count();
        $passed         = $attempts->filter(fn($a) => $a->passed())->count();
        $avgScore       = $attempts->count()
            ? (int) round($attempts->avg(fn($a) => $a->percentage()))
            : 0;

        $tasksDone    = $user->tasks()->where('is_done', true)->count();
        $tasksPending = $user->tasks()->where('is_done', false)->count();

        return view('progress.index', compact(
            'attempts', 'totalCourses', 'coursesEvaluated',
            'passed', 'avgScore', 'tasksDone', 'tasksPending'
        ));
    }
}
