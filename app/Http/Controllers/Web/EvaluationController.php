<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EvaluationAttempt;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $course    = Course::findOrFail($courseId);
        $questions = $course->content['evaluation']['questions'] ?? [];

        $answers  = $request->input('answers', []);
        $score    = 0;
        $details  = [];

        foreach ($questions as $q) {
            $num      = (string) $q['number'];
            $given    = strtoupper($answers[$num] ?? '');
            $correct  = strtoupper($q['correct']);
            $isRight  = $given === $correct;

            if ($isRight) $score++;

            $details[$num] = [
                'question'    => $q['question'],
                'given'       => $given,
                'correct'     => $correct,
                'is_correct'  => $isRight,
                'options'     => $q['options'],
                'explanation' => $q['explanation'] ?? '',
            ];
        }

        $attempt = EvaluationAttempt::create([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'answers'   => $details,
            'score'     => $score,
            'total'     => count($questions),
        ]);

        return redirect()->route('courses.result', [$courseId, $attempt->id]);
    }

    public function result($courseId, $attemptId)
    {
        $course  = Course::findOrFail($courseId);
        $attempt = EvaluationAttempt::where('id', $attemptId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('courses.result', compact('course', 'attempt'));
    }
}
