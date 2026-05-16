<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskViewController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->tasks()->create([
            'title'       => $request->title,
            'description' => $request->description,
            'is_done'     => false,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada correctamente.');
    }

    public function edit($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $task = auth()->user()->tasks()->findOrFail($id);
        $task->update([
            'title'       => $request->title,
            'description' => $request->description,
            'is_done'     => $request->boolean('is_done'),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy($id)
    {
        auth()->user()->tasks()->findOrFail($id)->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada.');
    }
}
