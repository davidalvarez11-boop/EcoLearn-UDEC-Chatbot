@extends('layouts.ecolearn')

@section('page-title', 'Mi Progreso')

@section('content')

{{-- ══ HEADER ══ --}}
<div class="rounded-4 p-4 mb-4 d-flex align-items-center gap-4 flex-wrap"
     style="background:linear-gradient(135deg,#006837 0%,#00924e 60%,#00b85f 100%);color:#fff;">
  <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
       style="width:60px;height:60px;background:rgba(255,255,255,.2);font-size:1.5rem;">
    <i class="bi bi-bar-chart-fill"></i>
  </div>
  <div class="flex-grow-1">
    <h4 class="fw-bold mb-1">Mi Progreso</h4>
    <p class="mb-0" style="opacity:.85;font-size:.9rem;">
      Sigue tu avance en evaluaciones y tareas
    </p>
  </div>
  @if($attempts->count())
  <div class="text-center px-4 py-2 rounded-3" style="background:rgba(255,255,255,.15);">
    <div class="fw-bold" style="font-size:1.6rem;">{{ $avgScore }}%</div>
    <div style="font-size:.72rem;opacity:.85;">Promedio general</div>
  </div>
  @endif
</div>

{{-- ══ STATS ══ --}}
<div class="row g-3 mb-4">
  @php
    $cards = [
      ['label'=>'Cursos disponibles',   'value'=>$totalCourses,      'icon'=>'bi-collection-fill',    'color'=>'#006837','bg'=>'#e8f5ee'],
      ['label'=>'Cursos evaluados',     'value'=>$coursesEvaluated,  'icon'=>'bi-patch-check-fill',   'color'=>'#4f46e5','bg'=>'#eef2ff'],
      ['label'=>'Evaluaciones aprobadas','value'=>$passed,           'icon'=>'bi-trophy-fill',        'color'=>'#f0a500','bg'=>'#fff8e1'],
      ['label'=>'Tareas completadas',   'value'=>$tasksDone,         'icon'=>'bi-check-circle-fill',  'color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ];
  @endphp
  @foreach($cards as $c)
  <div class="col-6 col-xl-3">
    <div class="card border-0 rounded-3 p-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:46px;height:46px;background:{{ $c['bg'] }};">
          <i class="bi {{ $c['icon'] }}" style="color:{{ $c['color'] }};font-size:1.25rem;"></i>
        </div>
        <div>
          <div class="fw-bold" style="font-size:1.6rem;line-height:1;color:#1a2e1a;">{{ $c['value'] }}</div>
          <div class="text-muted" style="font-size:.75rem;margin-top:2px;">{{ $c['label'] }}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div class="row g-3">

  {{-- ══ HISTORIAL DE EVALUACIONES ══ --}}
  <div class="col-lg-8">
    <div class="card border-0 rounded-3 h-100" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-4" style="color:#1a2e1a;">
          <i class="bi bi-clipboard2-data-fill me-2" style="color:#006837;"></i>Historial de evaluaciones
        </h6>

        @forelse($attempts as $attempt)
        @php $pct = $attempt->percentage(); $ok = $attempt->passed(); @endphp
        <div class="p-3 rounded-3 mb-3" style="background:#f8fffe;border:1px solid #e2ede8;">
          <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
            <div>
              <div class="fw-semibold" style="font-size:.9rem;color:#1a2e1a;">
                {{ $attempt->course->title ?? 'Curso eliminado' }}
              </div>
              <div class="text-muted" style="font-size:.75rem;">
                {{ $attempt->created_at->format('d M Y, H:i') }}
              </div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge rounded-pill px-3 py-1"
                    style="background:{{ $ok ? '#e8f5ee' : '#fdecea' }};
                           color:{{ $ok ? '#006837' : '#c0392b' }};font-size:.78rem;">
                <i class="bi {{ $ok ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-1"></i>
                {{ $ok ? 'Aprobado' : 'Reprobado' }}
              </span>
              <span class="fw-bold" style="font-size:1.1rem;color:{{ $ok ? '#006837' : '#c0392b' }};">
                {{ $pct }}%
              </span>
            </div>
          </div>
          {{-- Barra de progreso --}}
          <div class="progress" style="height:8px;border-radius:10px;background:#e2ede8;">
            <div class="progress-bar"
                 style="width:{{ $pct }}%;border-radius:10px;
                        background:{{ $pct >= 80 ? '#006837' : ($pct >= 60 ? '#00924e' : '#e74c3c') }};
                        transition:width .6s ease;">
            </div>
          </div>
          <div class="d-flex justify-content-between mt-1">
            <span class="text-muted" style="font-size:.72rem;">{{ $attempt->score }} / {{ $attempt->total }} correctas</span>
            <a href="{{ route('courses.result', [$attempt->course_id, $attempt->id]) }}"
               style="font-size:.72rem;color:#006837;text-decoration:none;font-weight:600;">
              Ver detalle <i class="bi bi-arrow-right ms-1"></i>
            </a>
          </div>
        </div>
        @empty
        <div class="text-center py-5">
          <i class="bi bi-clipboard2-x" style="font-size:2.5rem;color:#c8d8c8;"></i>
          <p class="text-muted mt-3 mb-1" style="font-size:.9rem;">Aún no has rendido ninguna evaluación.</p>
          <a href="{{ route('courses.index') }}" class="btn btn-sm mt-2"
             style="background:#006837;color:#fff;border-radius:8px;font-size:.82rem;">
            Explorar cursos
          </a>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- ══ RESUMEN LATERAL ══ --}}
  <div class="col-lg-4">

    {{-- Progreso de cursos --}}
    <div class="card border-0 rounded-3 mb-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-3" style="color:#1a2e1a;">
          <i class="bi bi-collection me-2" style="color:#006837;"></i>Cursos
        </h6>
        <div class="mb-2 d-flex justify-content-between" style="font-size:.83rem;">
          <span class="text-muted">Evaluados</span>
          <span class="fw-semibold">{{ $coursesEvaluated }} / {{ $totalCourses }}</span>
        </div>
        @php $coursesPct = $totalCourses > 0 ? (int)round($coursesEvaluated / $totalCourses * 100) : 0; @endphp
        <div class="progress mb-3" style="height:10px;border-radius:10px;background:#e8f5ee;">
          <div class="progress-bar" style="width:{{ $coursesPct }}%;border-radius:10px;background:#006837;"></div>
        </div>
        <div class="text-center" style="font-size:.78rem;color:#006837;font-weight:600;">{{ $coursesPct }}% completado</div>
      </div>
    </div>

    {{-- Resumen tareas --}}
    <div class="card border-0 rounded-3 mb-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-3" style="color:#1a2e1a;">
          <i class="bi bi-check2-square me-2" style="color:#f0a500;"></i>Tareas
        </h6>
        @php $total = $tasksDone + $tasksPending; $taskPct = $total > 0 ? (int)round($tasksDone / $total * 100) : 0; @endphp
        <div class="mb-2 d-flex justify-content-between" style="font-size:.83rem;">
          <span class="text-muted">Completadas</span>
          <span class="fw-semibold">{{ $tasksDone }} / {{ $total }}</span>
        </div>
        <div class="progress mb-3" style="height:10px;border-radius:10px;background:#fff8e1;">
          <div class="progress-bar" style="width:{{ $taskPct }}%;border-radius:10px;background:#f0a500;"></div>
        </div>
        <div class="d-flex gap-2 mt-2">
          <div class="flex-fill text-center rounded-3 p-2" style="background:#fff8e1;">
            <div class="fw-bold" style="color:#b07d00;font-size:1.1rem;">{{ $tasksPending }}</div>
            <div style="font-size:.7rem;color:#b07d00;">Pendientes</div>
          </div>
          <div class="flex-fill text-center rounded-3 p-2" style="background:#e8f5ee;">
            <div class="fw-bold" style="color:#006837;font-size:1.1rem;">{{ $tasksDone }}</div>
            <div style="font-size:.7rem;color:#006837;">Completadas</div>
          </div>
        </div>
      </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="card border-0 rounded-3" style="box-shadow:0 2px 12px rgba(0,0,0,.07);">
      <div class="card-body p-4">
        <h6 class="fw-bold mb-3" style="color:#1a2e1a;">
          <i class="bi bi-lightning-fill me-2" style="color:#f0a500;"></i>Accesos rápidos
        </h6>
        <div class="d-flex flex-column gap-2">
          <a href="{{ route('courses.index') }}"
             class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
             style="background:#e8f5ee;">
            <i class="bi bi-book-fill" style="color:#006837;font-size:1.1rem;"></i>
            <span style="font-size:.83rem;color:#006837;font-weight:600;">Explorar cursos</span>
          </a>
          <a href="{{ route('tasks.index') }}"
             class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none"
             style="background:#fff8e1;">
            <i class="bi bi-check2-square" style="color:#f0a500;font-size:1.1rem;"></i>
            <span style="font-size:.83rem;color:#b07d00;font-weight:600;">Mis tareas</span>
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
