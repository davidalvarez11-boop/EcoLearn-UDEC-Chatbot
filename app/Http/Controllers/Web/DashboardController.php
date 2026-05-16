<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EvaluationAttempt;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        $stats = [
            'courses_total'    => Course::count(),
            'tasks_pending'    => $user->tasks()->where('is_done', false)->count(),
            'tasks_done'       => $user->tasks()->where('is_done', true)->count(),
            'attempts_total'   => EvaluationAttempt::where('user_id', $user->id)->count(),
        ];

        $recentCourses = Course::latest()->take(3)->get();

        $recentTasks   = $user->tasks()->latest()->take(5)->get();

        $lastAttempt   = EvaluationAttempt::with('course')
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('dashboard.dashboard', compact(
            'stats', 'recentCourses', 'recentTasks', 'lastAttempt'
        ));
    }
}
