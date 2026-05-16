@extends('layouts.ecolearn')

@section('page-title', 'Mi Perfil')

@section('content')

@php
  $name     = auth()->user()->name;
  $initials = collect(explode(' ', $name))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->join('');
@endphp

<div class="row g-4">

  {{-- ══ COLUMNA AVATAR + INFO ══ --}}
  <div class="col-lg-4">
    <div class="card border-0 rounded-3 text-center p-4" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      {{-- Avatar con iniciales --}}
      <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 fw-bold"
           style="width:90px;height:90px;background:linear-gradient(135deg,#006837,#00924e);
                  color:#fff;font-size:1.8rem;letter-spacing:1px;">
        {{ $initials }}
      </div>

      <h5 class="fw-bold mb-0" style="color:#1a2e1a;">{{ $user->name }}</h5>
      <p class="text-muted mb-1" style="font-size:.83rem;">{{ $user->email }}</p>

      <span class="badge rounded-pill px-3 py-1 mb-3"
            style="background:{{ $user->isAdmin() ? '#e8f0fe' : '#e8f5ee' }};
                   color:{{ $user->isAdmin() ? '#3b5bdb' : '#006837' }};font-size:.75rem;">
        <i class="bi {{ $user->isAdmin() ? 'bi-shield-fill-check' : 'bi-mortarboard-fill' }} me-1"></i>
        {{ $user->isAdmin() ? 'Administrador' : 'Estudiante' }}
      </span>

      <hr>

      <div class="text-start">
        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f0f4f0;">
          <span class="text-muted" style="font-size:.82rem;">Miembro desde</span>
          <span class="fw-semibold" style="font-size:.82rem;">
            {{ $user->created_at->format('M Y') }}
          </span>
        </div>
        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f0f4f0;">
          <span class="text-muted" style="font-size:.82rem;">Tareas creadas</span>
          <span class="fw-semibold" style="font-size:.82rem;">
            {{ $user->tasks()->count() }}
          </span>
        </div>
        <div class="d-flex justify-content-between py-2">
          <span class="text-muted" style="font-size:.82rem;">Evaluaciones</span>
          <span class="fw-semibold" style="font-size:.82rem;">
            {{ $user->evaluationAttempts()->count() }}
          </span>
        </div>
      </div>
    </div>
  </div>

  {{-- ══ COLUMNA FORMULARIOS ══ --}}
  <div class="col-lg-8">

    {{-- Mensajes flash --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- ── DATOS PERSONALES ── --}}
    <div class="card border-0 rounded-3 mb-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#1a2e1a;">
          <i class="bi bi-person-fill me-2" style="color:#006837;"></i>Datos personales
        </h6>

        <form method="POST" action="{{ route('profile.update') }}">
          @csrf @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.84rem;color:#374151;">
              Nombre completo
            </label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}"
                   style="border-radius:10px;padding:.75rem 1rem;">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:.84rem;color:#374151;">
              Correo electrónico
            </label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}"
                   style="border-radius:10px;padding:.75rem 1rem;">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <button type="submit" class="btn fw-semibold px-4"
                  style="background:#006837;color:#fff;border-radius:10px;">
            <i class="bi bi-check2 me-1"></i> Guardar cambios
          </button>
        </form>
      </div>
    </div>

    {{-- ── CAMBIAR CONTRASEÑA ── --}}
    <div class="card border-0 rounded-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#1a2e1a;">
          <i class="bi bi-lock-fill me-2" style="color:#f0a500;"></i>Cambiar contraseña
        </h6>

        <form method="POST" action="{{ route('profile.password') }}">
          @csrf @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.84rem;color:#374151;">
              Contraseña actual
            </label>
            <input type="password" name="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   style="border-radius:10px;padding:.75rem 1rem;"
                   placeholder="Tu contraseña actual">
            @error('current_password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.84rem;color:#374151;">
              Nueva contraseña
            </label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   style="border-radius:10px;padding:.75rem 1rem;"
                   placeholder="Mínimo 8 caracteres">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:.84rem;color:#374151;">
              Confirmar nueva contraseña
            </label>
            <input type="password" name="password_confirmation"
                   class="form-control"
                   style="border-radius:10px;padding:.75rem 1rem;"
                   placeholder="Repite la nueva contraseña">
          </div>

          <button type="submit" class="btn fw-semibold px-4"
                  style="background:#f0a500;color:#fff;border-radius:10px;">
            <i class="bi bi-key-fill me-1"></i> Actualizar contraseña
          </button>
        </form>
      </div>
    </div>

  </div>
</div>

@endsection
