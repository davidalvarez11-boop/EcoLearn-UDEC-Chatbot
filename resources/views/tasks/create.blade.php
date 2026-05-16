@extends('layouts.ecolearn')

@section('page-title', 'Tareas')
@section('breadcrumb', 'Nueva tarea')

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
               style="width:56px;height:56px;background:#fff8e1;">
            <i class="bi bi-plus-square-fill" style="color:#f0a500;font-size:1.5rem;"></i>
          </div>
          <h5 class="fw-bold mb-1" style="color:#1a2e1a;">Nueva tarea</h5>
          <p class="text-muted mb-0" style="font-size:.85rem;">Registra una nueva tarea o actividad pendiente</p>
        </div>

        @if($errors->any())
          <div class="alert alert-danger" style="border-radius:10px;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('tasks.store') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
              Título <span class="text-danger">*</span>
            </label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}"
                   placeholder="Ej: Investigar puntos de reciclaje en el campus"
                   style="border-radius:10px;padding:.75rem 1rem;"
                   autofocus required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:.85rem;color:#374151;">
              Descripción <span class="text-muted fw-normal">(opcional)</span>
            </label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="4"
                      placeholder="Añade detalles o instrucciones sobre la tarea..."
                      style="border-radius:10px;padding:.75rem 1rem;resize:none;">{{ old('description') }}</textarea>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn flex-grow-1 fw-semibold py-2"
                    style="background:#006837;color:#fff;border-radius:10px;">
              <i class="bi bi-plus-circle-fill me-2"></i>Crear tarea
            </button>
            <a href="{{ route('tasks.index') }}"
               class="btn btn-outline-secondary fw-semibold px-4"
               style="border-radius:10px;">
              Cancelar
            </a>
          </div>
        </form>

      </div>
    </div>

  </div>
</div>

@endsection
