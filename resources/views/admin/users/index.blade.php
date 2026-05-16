@extends('layouts.admin')

@section('page-title', 'Estudiantes')
@section('breadcrumb', 'Gestión de estudiantes')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="fw-bold mb-0" style="color:#1a2636;">Estudiantes registrados</h5>
    <p class="text-muted mb-0" style="font-size:.82rem;">{{ $users->count() }} estudiante(s) en la plataforma</p>
  </div>
</div>

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
  </div>
@endif

@if($users->isEmpty())
  <div class="text-center py-5">
    <i class="bi bi-people text-muted" style="font-size:3rem;"></i>
    <p class="text-muted mt-3">No hay estudiantes registrados.</p>
  </div>
@else
  <div class="adm-stat-card card">
    <div class="table-responsive">
      <table class="table adm-table mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Tareas</th>
            <th>Evaluaciones</th>
            <th>Registro</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td class="text-muted" style="font-size:.8rem;">{{ $user->id }}</td>
            <td>
              <div class="d-flex align-items-center gap-2">
                @php
                  $initials = collect(explode(' ', $user->name))
                    ->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->join('');
                @endphp
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                     style="width:32px;height:32px;background:#e8f5ee;color:#006837;font-size:.75rem;">
                  {{ $initials }}
                </div>
                <span class="fw-semibold" style="font-size:.88rem;">{{ $user->name }}</span>
              </div>
            </td>
            <td class="text-muted" style="font-size:.85rem;">{{ $user->email }}</td>
            <td>
              <span class="badge" style="background:#fff8e1;color:#b07d00;">
                {{ $user->tasks_count }}
              </span>
            </td>
            <td>
              <span class="badge" style="background:#eef2ff;color:#4f46e5;">
                {{ $user->evaluation_attempts_count }}
              </span>
            </td>
            <td class="text-muted" style="font-size:.8rem;">
              {{ $user->created_at->format('d/m/Y') }}
            </td>
            <td class="text-end">
              <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                    class="d-inline"
                    onsubmit="return confirm('¿Eliminar al estudiante {{ addslashes($user->name) }}? Esta acción no se puede deshacer.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm"
                        style="background:#fdecea;color:#c0392b;border-radius:6px;"
                        title="Eliminar">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif

@endsection
