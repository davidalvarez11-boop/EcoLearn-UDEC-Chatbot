@extends('layouts.ecolearn')

@section('page-title', 'Cursos')
@section('breadcrumb', Str::limit($course->title, 45))

@section('content')

@php
  $modules    = $course->content['modules']    ?? [];
  $evaluation = $course->content['evaluation'] ?? [];
  $questions  = $evaluation['questions']       ?? [];
  $expected   = $course->content['expected_result'] ?? null;
@endphp

{{-- ── BACK BUTTON ── --}}
<a href="{{ route('courses.index') }}"
   class="btn btn-sm btn-outline-secondary mb-4"
   style="border-radius:8px;font-size:.82rem;">
  <i class="bi bi-arrow-left me-1"></i> Volver a cursos
</a>

{{-- ══════════════════════════════════════════════
     HERO DEL CURSO
══════════════════════════════════════════════ --}}
<div class="course-hero mb-4">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <span class="badge bg-white text-success mb-2" style="font-size:.72rem;font-weight:600;">
        <i class="bi bi-leaf-fill me-1"></i>Educación Ambiental · EcoLearn UDEC
      </span>
      <h2 class="fw-bold mb-2" style="font-size:1.55rem;line-height:1.3;">
        {{ $course->title }}
      </h2>
      <p class="mb-3" style="opacity:.9;font-size:.92rem;line-height:1.7;">
        {{ $course->description }}
      </p>
      <div class="d-flex flex-wrap gap-3">
        <span class="d-flex align-items-center gap-1"
              style="background:rgba(255,255,255,.2);padding:.35rem .75rem;border-radius:20px;font-size:.78rem;">
          <i class="bi bi-grid-3x3-gap-fill"></i>
          {{ count($modules) }} módulo{{ count($modules) !== 1 ? 's' : '' }}
        </span>
        <span class="d-flex align-items-center gap-1"
              style="background:rgba(255,255,255,.2);padding:.35rem .75rem;border-radius:20px;font-size:.78rem;">
          <i class="bi bi-patch-question-fill"></i>
          {{ count($questions) }} pregunta{{ count($questions) !== 1 ? 's' : '' }} de evaluación
        </span>
        <span class="d-flex align-items-center gap-1"
              style="background:rgba(255,255,255,.2);padding:.35rem .75rem;border-radius:20px;font-size:.78rem;">
          <i class="bi bi-clock-fill"></i>
          Autodirigido
        </span>
      </div>
    </div>
    <div class="col-md-4 text-center d-none d-md-block">
      <i class="bi bi-laptop-fill" style="font-size:5rem;opacity:.25;"></i>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     RESULTADO ESPERADO
══════════════════════════════════════════════ --}}
@if($expected)
<div class="eco-card card mb-4 p-4" style="border-left:4px solid #f0a500 !important;border-radius:10px;">
  <div class="d-flex align-items-start gap-3">
    <div style="width:38px;height:38px;background:#fff8e1;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <i class="bi bi-trophy-fill" style="color:#f0a500;font-size:1.1rem;"></i>
    </div>
    <div>
      <h6 class="fw-bold mb-1" style="color:#1a2e1a;">Resultado esperado</h6>
      <p class="mb-0 text-muted" style="font-size:.88rem;line-height:1.6;">{{ $expected }}</p>
    </div>
  </div>
</div>
@endif

{{-- ══════════════════════════════════════════════
     MÓDULOS
══════════════════════════════════════════════ --}}
<h5 class="fw-bold mb-3" style="color:#1a2e1a;">
  <i class="bi bi-grid-3x3-gap-fill me-2" style="color:#006837;"></i>
  Contenido del curso
</h5>

@foreach($modules as $module)
<div class="eco-card card mb-4">
  <div class="card-header d-flex align-items-center gap-3 py-3 px-4"
       style="background:#f8fffe;border-bottom:1px solid #e2ede8;border-radius:12px 12px 0 0;">
    <div class="module-badge">{{ $module['number'] }}</div>
    <div>
      <h6 class="fw-bold mb-0" style="color:#1a2e1a;font-size:.95rem;">
        <i class="bi {{ $module['icon'] ?? 'bi-bookmark-fill' }} me-2" style="color:#006837;"></i>
        {{ $module['title'] }}
      </h6>
    </div>
    <span class="ms-auto badge rounded-pill"
          style="background:#e8f5ee;color:#006837;font-size:.72rem;">
      Módulo {{ $module['number'] }}
    </span>
  </div>

  <div class="card-body px-4 py-3">

    {{-- Contenido principal --}}
    <p class="mb-3" style="color:#374151;font-size:.9rem;line-height:1.75;">
      {{ $module['content'] }}
    </p>

    {{-- Puntos clave --}}
    @if(!empty($module['key_points']))
      <div class="mb-3 p-3"
           style="background:#f0f9f4;border-radius:8px;border:1px solid #c3e6d4;">
        <p class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
          <i class="bi bi-lightbulb-fill me-1"></i> Puntos clave
        </p>
        <ul class="mb-0 ps-3" style="font-size:.85rem;color:#374151;">
          @foreach($module['key_points'] as $point)
            <li class="mb-1">{{ $point }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Actividad --}}
    @if(!empty($module['activity']))
      @php $act = $module['activity']; @endphp
      <div class="activity-strip mt-2">
        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="bi {{ $act['icon'] ?? 'bi-pencil-square' }}" style="color:#f0a500;font-size:1rem;"></i>
          <span class="fw-semibold" style="color:#92600a;font-size:.82rem;">
            Actividad · {{ $act['type'] }}
          </span>
        </div>
        <p class="mb-0" style="font-size:.86rem;color:#5a4a20;line-height:1.65;">
          {{ $act['description'] }}
        </p>
      </div>
    @endif

  </div>
</div>
@endforeach

{{-- ══════════════════════════════════════════════
     EVALUACIÓN INTERACTIVA
══════════════════════════════════════════════ --}}
@if(!empty($questions))

<div class="mt-5 mb-3">
  <div class="d-flex align-items-center gap-2 mb-1">
    <i class="bi bi-clipboard2-check-fill fs-5" style="color:#006837;"></i>
    <h5 class="fw-bold mb-0" style="color:#1a2e1a;">
      {{ $evaluation['title'] ?? 'Evaluación final' }}
    </h5>
  </div>
  @if(!empty($evaluation['description']))
    <p class="text-muted mb-1" style="font-size:.87rem;padding-left:1.85rem;">
      {{ $evaluation['description'] }}
    </p>
  @endif
  <p class="text-muted mb-4" style="font-size:.8rem;padding-left:1.85rem;">
    <i class="bi bi-info-circle me-1"></i>
    Selecciona una opción por pregunta y presiona <strong>Enviar evaluación</strong>.
    Necesitas responder al menos el <strong>60%</strong> correctamente para aprobar.
  </p>
</div>

<form method="POST" action="{{ route('courses.evaluate', $course->id) }}" id="eval-form">
  @csrf

  @foreach($questions as $q)
  <div class="eco-card card question-card mb-3 px-4 py-4" id="q-{{ $q['number'] }}">
    <div class="d-flex align-items-start gap-3 mb-3">
      <div class="module-badge" style="width:32px;height:32px;font-size:.8rem;flex-shrink:0;">
        {{ $q['number'] }}
      </div>
      <p class="fw-semibold mb-0" style="color:#1a2e1a;font-size:.92rem;line-height:1.55;">
        {{ $q['question'] }}
      </p>
    </div>

    <div class="ps-5">
      @foreach($q['options'] as $letter => $text)
        <label class="option-item d-flex align-items-center gap-2 mb-2"
               style="cursor:pointer;transition:background .2s;"
               onmouseover="this.style.background='#dff0e8'"
               onmouseout="this.style.background='var(--eco-green-pale, #e8f5ee)'">
          <input type="radio"
                 name="answers[{{ $q['number'] }}]"
                 value="{{ $letter }}"
                 class="form-check-input m-0 flex-shrink-0"
                 style="accent-color:#006837;width:1.1rem;height:1.1rem;">
          <span class="option-letter">{{ $letter }}</span>
          <span style="font-size:.9rem;">{{ $text }}</span>
        </label>
      @endforeach
    </div>
  </div>
  @endforeach

  {{-- SUBMIT --}}
  <div class="eco-card card p-4 mt-2"
       style="background:linear-gradient(135deg,#f0f9f4,#e8f5ee);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <div>
        <p class="fw-semibold mb-0" style="color:#1a2e1a;">
          <i class="bi bi-send-check-fill me-2" style="color:#006837;"></i>
          ¿Respondiste todas las preguntas?
        </p>
        <p class="text-muted mb-0" style="font-size:.82rem;">
          {{ count($questions) }} pregunta(s) en total · El resultado se muestra inmediatamente.
        </p>
      </div>
      <button type="submit" id="submit-btn"
              class="btn fw-semibold px-4"
              style="background:#006837;color:#fff;border-radius:8px;font-size:.92rem;">
        <i class="bi bi-send-fill me-2"></i>Enviar evaluación
      </button>
    </div>
  </div>
</form>

<script>
document.getElementById('eval-form').addEventListener('submit', function(e) {
  const total   = {{ count($questions) }};
  const answered = document.querySelectorAll('#eval-form input[type="radio"]:checked').length;
  if (answered < total) {
    e.preventDefault();
    const missing = total - answered;
    alert(`Aún tienes ${missing} pregunta(s) sin responder. Por favor respóndelas todas antes de enviar.`);
    return;
  }
  const btn = document.getElementById('submit-btn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
});
</script>

@endif

{{-- ── FOOTER CTA ── --}}
<div class="text-center mt-5 py-4 px-3 eco-card card"
     style="background:linear-gradient(135deg,#f0f9f4,#e8f5ee);">
  <i class="bi bi-patch-check-fill fs-2 mb-2" style="color:#006837;"></i>
  <h6 class="fw-bold" style="color:#1a2e1a;">¿Listo para seguir aprendiendo?</h6>
  <p class="text-muted mb-3" style="font-size:.85rem;">
    Explora más cursos sobre sostenibilidad y amplía tu impacto positivo.
  </p>
  <a href="{{ route('courses.index') }}"
     class="btn fw-semibold px-4"
     style="background:#006837;color:#fff;border-radius:8px;">
    <i class="bi bi-collection-fill me-2"></i>Ver todos los cursos
  </a>
</div>

@endsection
