<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'expected_result'  => 'required|string',
            'modules'          => 'required|array|min:1',
            'modules.*.title'  => 'required|string',
            'modules.*.content'=> 'required|string',
            'questions'        => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.correct'  => 'required|in:A,B,C,D',
        ]);

        Course::create([
            'title'       => $request->title,
            'description' => $request->description,
            'content'     => $this->buildContent($request),
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'expected_result'  => 'required|string',
            'modules'          => 'required|array|min:1',
            'modules.*.title'  => 'required|string',
            'modules.*.content'=> 'required|string',
            'questions'        => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.correct'  => 'required|in:A,B,C,D',
        ]);

        $course->update([
            'title'       => $request->title,
            'description' => $request->description,
            'content'     => $this->buildContent($request),
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso eliminado.');
    }

    private function buildContent(Request $request): array
    {
        $iconMap = [
            'laptop'  => 'bi-laptop',
            'recycle' => 'bi-recycle',
            'leaf'    => 'bi-leaf-fill',
            'plug'    => 'bi-plug-fill',
            'book'    => 'bi-book-fill',
            'sun'     => 'bi-sun-fill',
            'water'   => 'bi-droplet-half',
            'repeat'  => 'bi-arrow-repeat',
        ];

        $modules = [];
        foreach ($request->input('modules', []) as $i => $mod) {
            $keyPoints = array_values(array_filter($mod['key_points'] ?? []));
            $modules[] = [
                'number'     => $i + 1,
                'title'      => $mod['title'],
                'icon'       => $iconMap[$mod['icon'] ?? 'book'] ?? 'bi-book-fill',
                'color'      => '#006837',
                'content'    => $mod['content'],
                'key_points' => $keyPoints,
                'activity'   => [
                    'icon'        => 'bi-pencil-square',
                    'type'        => $mod['activity_type'] ?? 'Actividad práctica',
                    'description' => $mod['activity_description'] ?? '',
                ],
            ];
        }

        $questions = [];
        foreach ($request->input('questions', []) as $i => $q) {
            $questions[] = [
                'number'      => $i + 1,
                'question'    => $q['question'],
                'options'     => [
                    'A' => $q['option_a'] ?? '',
                    'B' => $q['option_b'] ?? '',
                    'C' => $q['option_c'] ?? '',
                    'D' => $q['option_d'] ?? '',
                ],
                'correct'     => strtoupper($q['correct']),
                'explanation' => $q['explanation'] ?? '',
            ];
        }

        return [
            'expected_result' => $request->expected_result,
            'modules'         => $modules,
            'evaluation'      => [
                'title'       => $request->input('eval_title', 'Evaluación final del curso'),
                'description' => $request->input('eval_description', 'Responde las siguientes preguntas para verificar tus aprendizajes.'),
                'questions'   => $questions,
            ],
        ];
    }
}
