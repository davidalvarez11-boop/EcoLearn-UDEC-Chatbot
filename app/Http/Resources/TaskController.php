<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->latest()->paginate(10);
        return TaskResource::collection($tasks);
    }
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
        ]);
        return (new TaskResource($task))
            ->response()->setStatusCode(201);
    }
    public function show(Task $task)
    {
        $this->authorizeOwner($task);
        return new TaskResource($task);
    }
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorizeOwner($task);
        $task->update($request->validated());
        return new TaskResource($task);
    }
    public function destroy(Task $task)
    {
        $this->authorizeOwner($task);
        $task->delete();
        return response()->json(['message' => 'Tarea eliminada']);
    }
    private function authorizeOwner(Task $task): void
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a esta tarea.');
        }
    }
}
