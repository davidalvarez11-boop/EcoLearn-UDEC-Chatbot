@extends('layouts.ecolearn')

@section('page-title', 'Tareas')
@section('breadcrumb', 'Editar tarea')

@section('content')

<div class="row justify-content-center">
  <div class="col-lg-7">

    <a href="{{ route('tasks.index') }}"
       class="btn btn-sm btn-outline-secondary mb-4" style="border-radius:8px;font-size:.82rem;">
      <i class="bi bi-arrow-left me-1"></i> Volver a tareas
    </a>

    <div class="card border-0 rounded-3" style="box-shadow:0 4px 24px rgba(0,0,0,.09);">
      <div class="card-body p-5">

        <div class="text-center mb-4">
          <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3"
               style="width:56px;height:56px;background:#e0f2fe;">
            <i class="bi bi-pencil-fill" style="color:#0ea5e9;font-size:1.4rem;"></i>
          </div>
          <h5 class="fw-bold mb-1" style="color:#1a2e1a;">Editar tarea</h5>
          <p class="text-muted mb-0" style="font-size:.85rem;">Modifica los datos de tu tarea</p>
        </div>

        @if(session('success'))
          <div class="alert alert-success d-flex align-items-center gap-2" style="border-radius:10px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger" style="border-radius:10px;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
          @csrf @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
              Título <span class="text-danger">*</span>
            </label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $task->title) }}"
                   style="border-radius:10px;padding:.75rem 1rem;"
                   required autofocus>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
              Descripción
            </label>
            <textarea name="description"
                      class="form-control"
                      rows="4"
                      style="border-radius:10px;padding:.75rem 1rem;resize:none;">{{ old('description', $task->description) }}</textarea>
          </div>

          <div class="mb-4">
            <div class="form-check form-switch ps-0 d-flex align-items-center gap-3 p-3 rounded-3"
                 style="background:#f8fffe;border:1px solid #e2ede8;">
              <input class="form-check-input m-0 flex-shrink-0" type="checkbox"
                     name="is_done" value="1" id="isDone"
                     style="width:2.5rem;height:1.3rem;cursor:pointer;"
                     {{ old('is_done', $task->is_done) ? 'checked' : '' }}>
              <label class="form-check-label fw-semibold" for="isDone"
                     style="font-size:.88rem;color:#1a2e1a;cursor:pointer;">
                <i class="bi bi-check-circle-fill me-1" style="color:#006837;"></i>
                Marcar como completada
              </label>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn flex-grow-1 fw-semibold py-2"
                    style="background:#006837;color:#fff;border-radius:10px;">
              <i class="bi bi-check2-circle me-2"></i>Guardar cambios
            </button>
            <a href="{{ route('tasks.index') }}"
               class="btn btn-outline-secondary fw-semibold px-4"
               style="border-radius:10px;">
              Cancelar
            </a>
          </div>
        </form>

        <div class="mt-3 pt-3 border-top">
          <form method="POST" action="{{ route('tasks.destroy', $task->id) }}"
                onsubmit="return confirm('¿Eliminar esta tarea permanentemente?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm w-100"
                    style="background:#fdecea;color:#c0392b;border-radius:8px;font-size:.82rem;">
              <i class="bi bi-trash me-1"></i> Eliminar tarea
            </button>
          </form>
        </div>

      </div>
    </div>

  </div>
</div>

@endsection
