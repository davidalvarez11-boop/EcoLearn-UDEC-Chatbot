@extends('layouts.ecolearn')

@section('page-title', 'Tareas')

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
  <div>
    <h5 class="fw-bold mb-0" style="color:#1a2e1a;">Mis tareas</h5>
    <p class="text-muted mb-0" style="font-size:.82rem;">
      {{ $tasks->count() }} tarea(s) registrada(s)
    </p>
  </div>
  <a href="{{ route('tasks.create') }}"
     class="btn d-flex align-items-center gap-2"
     style="background:#006837;color:#fff;border-radius:8px;font-size:.88rem;">
    <i class="bi bi-plus-circle-fill"></i> Nueva tarea
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
  </div>
@endif

@php
  $pending   = $tasks->where('is_done', false);
  $completed = $tasks->where('is_done', true);
  $pct       = $tasks->count() > 0 ? (int) round(($completed->count() / $tasks->count()) * 100) : 0;
@endphp

{{-- PROGRESS BAR --}}
@if($tasks->count() > 0)
<div class="card border-0 rounded-3 p-4 mb-4" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <span class="fw-semibold" style="font-size:.85rem;color:#1a2e1a;">
      Progreso general
    </span>
    <span class="fw-bold" style="color:#006837;">{{ $pct }}%</span>
  </div>
  <div class="progress" style="height:10px;border-radius:10px;">
    <div class="progress-bar" role="progressbar"
         style="width:{{ $pct }}%;background:#006837;border-radius:10px;"
         aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  <div class="d-flex gap-4 mt-2">
    <span class="text-muted" style="font-size:.78rem;">
      <i class="bi bi-hourglass-split me-1" style="color:#f0a500;"></i>
      {{ $pending->count() }} pendiente(s)
    </span>
    <span class="text-muted" style="font-size:.78rem;">
      <i class="bi bi-check-circle-fill me-1" style="color:#006837;"></i>
      {{ $completed->count() }} completada(s)
    </span>
  </div>
</div>
@endif

@if($tasks->isEmpty())
  <div class="text-center py-5">
    <i class="bi bi-inbox text-muted" style="font-size:3.5rem;"></i>
    <h6 class="mt-3 text-muted">No tienes tareas aún</h6>
    <p class="text-muted mb-3" style="font-size:.85rem;">Crea tu primera tarea para comenzar.</p>
    <a href="{{ route('tasks.create') }}"
       class="btn" style="background:#006837;color:#fff;border-radius:8px;">
      <i class="bi bi-plus-circle me-2"></i>Crear primera tarea
    </a>
  </div>
@else

  {{-- PENDIENTES --}}
  @if($pending->count())
  <h6 class="fw-bold mb-2" style="color:#1a2e1a;font-size:.85rem;text-transform:uppercase;letter-spacing:.5px;">
    <i class="bi bi-hourglass-split me-1" style="color:#f0a500;"></i>Pendientes ({{ $pending->count() }})
  </h6>
  <div class="card border-0 rounded-3 mb-4" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
    @foreach($pending as $task)
    <div class="d-flex align-items-center gap-3 px-4 py-3
                {{ !$loop->last ? 'border-bottom' : '' }}"
         style="border-color:#f0f4f0 !important;">

      {{-- Toggle done --}}
      <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="flex-shrink-0">
        @csrf @method('PUT')
        <input type="hidden" name="title"       value="{{ $task->title }}">
        <input type="hidden" name="description" value="{{ $task->description }}">
        <input type="hidden" name="is_done"     value="1">
        <button type="submit" class="btn p-0 border-0"
                style="width:28px;height:28px;border-radius:50%;background:#fff3cd;color:#f0a500;"
                title="Marcar como completada">
          <i class="bi bi-circle" style="font-size:1rem;"></i>
        </button>
      </form>

      <div class="flex-grow-1">
        <div class="fw-semibold" style="font-size:.9rem;color:#1a2e1a;">{{ $task->title }}</div>
        @if($task->description)
          <div class="text-muted" style="font-size:.78rem;">{{ Str::limit($task->description, 80) }}</div>
        @endif
      </div>

      <div class="d-flex gap-1 flex-shrink-0">
        <a href="{{ route('tasks.edit', $task->id) }}"
           class="btn btn-sm"
           style="background:#e0f2fe;color:#0ea5e9;border-radius:6px;"
           title="Editar">
          <i class="bi bi-pencil"></i>
        </a>
        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}"
              onsubmit="return confirm('¿Eliminar esta tarea?')">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-sm"
                  style="background:#fdecea;color:#c0392b;border-radius:6px;"
                  title="Eliminar">
            <i class="bi bi-trash"></i>
          </button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  {{-- COMPLETADAS --}}
  @if($completed->count())
  <h6 class="fw-bold mb-2" style="color:#1a2e1a;font-size:.85rem;text-transform:uppercase;letter-spacing:.5px;">
    <i class="bi bi-check-circle-fill me-1" style="color:#006837;"></i>Completadas ({{ $completed->count() }})
  </h6>
  <div class="card border-0 rounded-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
    @foreach($completed as $task)
    <div class="d-flex align-items-center gap-3 px-4 py-3
                {{ !$loop->last ? 'border-bottom' : '' }}"
         style="border-color:#f0f4f0 !important;opacity:.75;">

      {{-- Toggle undo --}}
      <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="flex-shrink-0">
        @csrf @method('PUT')
        <input type="hidden" name="title"       value="{{ $task->title }}">
        <input type="hidden" name="description" value="{{ $task->description }}">
        <input type="hidden" name="is_done"     value="0">
        <button type="submit" class="btn p-0 border-0"
                style="width:28px;height:28px;border-radius:50%;background:#e8f5ee;color:#006837;"
                title="Marcar como pendiente">
          <i class="bi bi-check-circle-fill" style="font-size:1rem;"></i>
        </button>
      </form>

      <div class="flex-grow-1">
        <div class="fw-semibold text-decoration-line-through text-muted"
             style="font-size:.9rem;">{{ $task->title }}</div>
        @if($task->description)
          <div class="text-muted" style="font-size:.78rem;">{{ Str::limit($task->description, 80) }}</div>
        @endif
      </div>

      <form method="POST" action="{{ route('tasks.destroy', $task->id) }}"
            onsubmit="return confirm('¿Eliminar esta tarea?')" class="flex-shrink-0">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm"
                style="background:#fdecea;color:#c0392b;border-radius:6px;">
          <i class="bi bi-trash"></i>
        </button>
      </form>
    </div>
    @endforeach
  </div>
  @endif

@endif

@endsection
