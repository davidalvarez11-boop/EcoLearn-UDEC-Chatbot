<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EvaluationAttempt;
use App\Models\Task;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'    => User::where('role', 'student')->count(),
            'courses'  => Course::count(),
            'tasks'    => Task::count(),
            'attempts' => EvaluationAttempt::count(),
        ];

        $recentAttempts = EvaluationAttempt::with(['user', 'course'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAttempts'));
    }
}
