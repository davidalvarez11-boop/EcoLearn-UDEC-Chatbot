@extends('layouts.ecolearn')

@section('page-title', 'Inicio')

@section('content')

@php
  $name     = auth()->user()->name;
  $initials = collect(explode(' ', $name))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->join('');
  $hour     = now()->hour;
  $greeting = $hour < 12 ? 'Buenos días' : ($hour < 19 ? 'Buenas tardes' : 'Buenas noches');
@endphp

{{-- ══ WELCOME BANNER ══ --}}
<div class="rounded-4 p-4 mb-4 d-flex align-items-center gap-4 flex-wrap"
     style="background:linear-gradient(135deg,#006837 0%,#00924e 60%,#00b85f 100%);color:#fff;">
  <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
       style="width:64px;height:64px;background:rgba(255,255,255,.2);font-size:1.4rem;letter-spacing:1px;">
    {{ $initials }}
  </div>
  <div class="flex-grow-1">
    <h4 class="fw-bold mb-1">{{ $greeting }}, {{ explode(' ', $name)[0] }} 👋</h4>
    <p class="mb-0" style="opacity:.85;font-size:.9rem;">
      Bienvenido a EcoLearn UDEC · Plataforma de educación ambiental
    </p>
  </div>
  @if($lastAttempt)
  <div class="text-center px-4 py-2 rounded-3" style="background:rgba(255,255,255,.15);">
    <div class="fw-bold" style="font-size:1.4rem;">{{ $lastAttempt->percentage() }}%</div>
    <div style="font-size:.72rem;opacity:.85;">Última evaluación</div>
  </div>
  @endif
</div>

{{-- ══ STATS ROW ══ --}}
<div class="row g-3 mb-4">
  @php
    $statCards = [
      ['label'=>'Cursos disponibles',   'value'=>$stats['courses_total'],  'icon'=>'bi-collection-fill',  'color'=>'#006837','bg'=>'#e8f5ee'],
      ['label'=>'Evaluaciones rendidas','value'=>$stats['attempts_total'], 'icon'=>'bi-clipboard2-check-fill','color'=>'#4f46e5','bg'=>'#eef2ff'],
      ['label'=>'Tareas pendientes',    'value'=>$stats['tasks_pending'],  'icon'=>'bi-hourglass-split',  'color'=>'#f0a500','bg'=>'#fff8e1'],
      ['label'=>'Tareas completadas',   'value'=>$stats['tasks_done'],     'icon'=>'bi-check-circle-fill','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ];
  @endphp

  @foreach($statCards as $sc)
  <div class="col-6 col-xl-3">
    <div class="card border-0 rounded-3 p-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:46px;height:46px;background:{{ $sc['bg'] }};">
          <i class="bi {{ $sc['icon'] }}" style="color:{{ $sc['color'] }};font-size:1.25rem;"></i>
        </div>
        <div>
          <div class="fw-bold" style="font-size:1.6rem;line-height:1;color:#1a2e1a;">{{ $sc['value'] }}</div>
          <div class="text-muted" style="font-size:.75rem;margin-top:2px;">{{ $sc['label'] }}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div class="row g-3">

  {{-- ══ CURSOS RECIENTES ══ --}}
  <div class="col-lg-7">
    <div class="card border-0 rounded-3 h-100" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-bold mb-0" style="color:#1a2e1a;">
            <i class="bi bi-collection me-2" style="color:#006837;"></i>Cursos disponibles
          </h6>
          <a href="{{ route('courses.index') }}"
             style="font-size:.8rem;color:#006837;text-decoration:none;font-weight:600;">
            Ver todos <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>

        @forelse($recentCourses as $course)
        @php
          $icons = ['bi-laptop','bi-recycle','bi-droplet-half'];
          $ci    = $loop->index % 3;
        @endphp
        <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-2"
             style="background:#f8fffe;border:1px solid #e2ede8;transition:background .2s;"
             onmouseover="this.style.background='#edf7f0'"
             onmouseout="this.style.background='#f8fffe'">
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
               style="width:44px;height:44px;background:linear-gradient(135deg,#006837,#00924e);">
            <i class="bi {{ $icons[$ci] }} text-white" style="font-size:1.1rem;"></i>
          </div>
          <div class="flex-grow-1 overflow-hidden">
            <div class="fw-semibold text-truncate" style="font-size:.88rem;color:#1a2e1a;">
              {{ $course->title }}
            </div>
            <div class="text-muted text-truncate" style="font-size:.77rem;">
              {{ Str::limit($course->description, 60) }}
            </div>
          </div>
          <a href="{{ route('courses.show', $course->id) }}"
             class="btn btn-sm flex-shrink-0"
             style="background:#006837;color:#fff;border-radius:6px;font-size:.78rem;white-space:nowrap;">
            Iniciar
          </a>
        </div>
        @empty
          <p class="text-muted" style="font-size:.85rem;">No hay cursos disponibles aún.</p>
        @endforelse

      </div>
    </div>
  </div>

  {{-- ══ TAREAS RECIENTES + ACCIONES ══ --}}
  <div class="col-lg-5">

    {{-- Mis tareas recientes --}}
    <div class="card border-0 rounded-3 mb-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-bold mb-0" style="color:#1a2e1a;">
            <i class="bi bi-check2-square me-2" style="color:#f0a500;"></i>Mis tareas
          </h6>
          <a href="{{ route('tasks.index') }}"
             style="font-size:.8rem;color:#006837;text-decoration:none;font-weight:600;">
            Ver todas <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>

        @forelse($recentTasks as $task)
        <div class="d-flex align-items-center gap-2 py-2"
             style="border-bottom:1px solid #f0f4f0;">
          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
               style="width:28px;height:28px;background:{{ $task->is_done ? '#e8f5ee' : '#fff8e1' }};">
            <i class="bi {{ $task->is_done ? 'bi-check2' : 'bi-clock' }}"
               style="font-size:.8rem;color:{{ $task->is_done ? '#006837' : '#f0a500' }};"></i>
          </div>
          <span class="flex-grow-1 text-truncate {{ $task->is_done ? 'text-muted' : '' }}"
                style="font-size:.85rem;{{ $task->is_done ? 'text-decoration:line-through;' : '' }}">
            {{ $task->title }}
          </span>
          <a href="{{ route('tasks.edit', $task->id) }}"
             class="text-muted flex-shrink-0" style="font-size:.8rem;">
            <i class="bi bi-pencil"></i>
          </a>
        </div>
        @empty
          <p class="text-muted mb-2" style="font-size:.83rem;">Sin tareas aún.</p>
        @endforelse

        <a href="{{ route('tasks.create') }}"
           class="btn btn-sm w-100 mt-3"
           style="background:#fff8e1;color:#b07d00;border:1px solid #f0d080;border-radius:8px;font-size:.82rem;">
          <i class="bi bi-plus-circle me-1"></i> Nueva tarea
        </a>
      </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="card border-0 rounded-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-3" style="color:#1a2e1a;">
          <i class="bi bi-lightning-fill me-2" style="color:#f0a500;"></i>Accesos rápidos
        </h6>
        <div class="row g-2">
          <div class="col-6">
            <a href="{{ route('courses.index') }}"
               class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 text-decoration-none"
               style="background:#e8f5ee;min-height:80px;">
              <i class="bi bi-book-fill mb-1" style="color:#006837;font-size:1.3rem;"></i>
              <span style="font-size:.75rem;color:#006837;font-weight:600;">Cursos</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('tasks.create') }}"
               class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 text-decoration-none"
               style="background:#fff8e1;min-height:80px;">
              <i class="bi bi-plus-square-fill mb-1" style="color:#f0a500;font-size:1.3rem;"></i>
              <span style="font-size:.75rem;color:#b07d00;font-weight:600;">Nueva tarea</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('profile.index') }}"
               class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 text-decoration-none"
               style="background:#e0f2fe;min-height:80px;">
              <i class="bi bi-person-fill mb-1" style="color:#0ea5e9;font-size:1.3rem;"></i>
              <span style="font-size:.75rem;color:#0369a1;font-weight:600;">Mi perfil</span>
            </a>
          </div>
          <div class="col-6">
            <a href="{{ route('progress.index') }}"
               class="d-flex flex-column align-items-center justify-content-center p-3 rounded-3 text-decoration-none"
               style="background:#f3e8ff;min-height:80px;">
              <i class="bi bi-bar-chart-fill mb-1" style="color:#7c3aed;font-size:1.3rem;"></i>
              <span style="font-size:.75rem;color:#6d28d9;font-weight:600;">Progreso</span>
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
