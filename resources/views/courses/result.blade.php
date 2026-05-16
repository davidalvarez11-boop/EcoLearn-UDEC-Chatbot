@extends('layouts.ecolearn')

@section('page-title', 'Resultado')
@section('breadcrumb', 'Evaluación · ' . Str::limit($course->title, 35))

@section('content')

@php
  $pct    = $attempt->percentage();
  $passed = $attempt->passed();
  $color  = $passed ? '#006837' : '#c0392b';
  $bgPale = $passed ? '#e8f5ee'  : '#fdecea';
  $icon   = $passed ? 'bi-patch-check-fill' : 'bi-x-circle-fill';
  $label  = $passed ? 'Aprobado' : 'No aprobado';
@endphp

{{-- Back --}}
<a href="{{ route('courses.show', $course->id) }}"
   class="btn btn-sm btn-outline-secondary mb-4" style="border-radius:8px;font-size:.82rem;">
  <i class="bi bi-arrow-left me-1"></i> Volver al curso
</a>

{{-- ══ RESULTADO CARD ══ --}}
<div class="eco-card card mb-4 overflow-hidden">
  <div style="background:linear-gradient(135deg,{{ $color }},{{ $passed ? '#00924e' : '#e74c3c' }});padding:2rem 2.5rem;">
    <div class="d-flex align-items-center gap-4">
      <i class="bi {{ $icon }} text-white" style="font-size:3.5rem;"></i>
      <div class="text-white">
        <h3 class="fw-bold mb-1">{{ $label }}</h3>
        <p class="mb-0" style="opacity:.9;font-size:.92rem;">
          {{ $course->title }}
        </p>
      </div>
      <div class="ms-auto text-center text-white">
        <div class="fw-bold" style="font-size:3rem;line-height:1;">{{ $pct }}%</div>
        <div style="font-size:.82rem;opacity:.85;">
          {{ $attempt->score }} de {{ $attempt->total }} correctas
        </div>
      </div>
    </div>
  </div>

  {{-- Barra de progreso --}}
  <div style="background:#f4f6f8;padding:.75rem 2.5rem;">
    <div class="progress" style="height:10px;border-radius:10px;">
      <div class="progress-bar" role="progressbar"
           style="width:{{ $pct }}%;background:{{ $color }};border-radius:10px;"
           aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
      </div>
    </div>
    <div class="d-flex justify-content-between mt-1">
      <small class="text-muted" style="font-size:.74rem;">0%</small>
      <small class="text-muted" style="font-size:.74rem;">Mínimo aprobatorio: 60%</small>
      <small class="text-muted" style="font-size:.74rem;">100%</small>
    </div>
  </div>
</div>

{{-- ══ DETALLE POR PREGUNTA ══ --}}
<h6 class="fw-bold mb-3" style="color:#1a2e1a;">
  <i class="bi bi-list-check me-2" style="color:#006837;"></i>Revisión pregunta por pregunta
</h6>

@foreach($attempt->answers as $num => $detail)
  @php
    $right     = $detail['is_correct'];
    $cardColor = $right ? '#e8f5ee' : '#fdecea';
    $border    = $right ? '#006837' : '#c0392b';
    $icon2     = $right ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
    $iconColor = $right ? '#006837' : '#c0392b';
  @endphp

  <div class="eco-card card mb-3"
       style="border-left:4px solid {{ $border }} !important;">
    <div class="card-body px-4 py-3">

      {{-- Header pregunta --}}
      <div class="d-flex align-items-start gap-3 mb-3">
        <div class="module-badge" style="width:30px;height:30px;font-size:.78rem;flex-shrink:0;">
          {{ $num }}
        </div>
        <p class="fw-semibold mb-0" style="color:#1a2e1a;font-size:.92rem;line-height:1.5;flex:1;">
          {{ $detail['question'] }}
        </p>
        <i class="bi {{ $icon2 }}" style="color:{{ $iconColor }};font-size:1.3rem;flex-shrink:0;"></i>
      </div>

      <div class="ps-5">
        {{-- Opciones --}}
        @foreach($detail['options'] as $letter => $text)
          @php
            $isGiven   = strtoupper($letter) === $detail['given'];
            $isCorrect = strtoupper($letter) === $detail['correct'];
            $bg = '#f4f6f8';
            $fw = '';
            $extra = '';
            if ($isCorrect) { $bg = '#e8f5ee'; $fw = 'fw-semibold'; $extra = 'border:1px solid #006837;'; }
            if ($isGiven && !$isCorrect) { $bg = '#fdecea'; $fw = 'fw-semibold'; $extra = 'border:1px solid #c0392b;'; }
          @endphp
          <div class="d-flex align-items-center gap-2 mb-1 px-3 py-2 rounded"
               style="background:{{ $bg }};{{ $extra }}">
            <span class="option-letter" style="{{ $isCorrect ? 'background:#006837;' : ($isGiven ? 'background:#c0392b;' : '') }}">
              {{ $letter }}
            </span>
            <span class="{{ $fw }}" style="font-size:.87rem;">{{ $text }}</span>
            @if($isCorrect)
              <i class="bi bi-check2 ms-auto" style="color:#006837;font-weight:700;"></i>
            @elseif($isGiven && !$isCorrect)
              <i class="bi bi-x ms-auto" style="color:#c0392b;font-weight:700;"></i>
            @endif
          </div>
        @endforeach

        {{-- Tu respuesta --}}
        @if($detail['given'])
          <p class="mt-2 mb-1" style="font-size:.8rem;color:#555;">
            Tu respuesta: <strong>{{ $detail['given'] }}</strong>
            @if(!$right)
              · Respuesta correcta: <strong style="color:#006837;">{{ $detail['correct'] }}</strong>
            @endif
          </p>
        @else
          <p class="mt-2 mb-1" style="font-size:.8rem;color:#c0392b;">
            Sin respuesta · Respuesta correcta: <strong>{{ $detail['correct'] }}</strong>
          </p>
        @endif

        {{-- Explicación --}}
        @if(!empty($detail['explanation']))
          <div class="mt-2 p-2 rounded"
               style="background:#f0f9f4;border:1px solid #c3e6d4;font-size:.81rem;color:#1a5c33;">
            <i class="bi bi-info-circle-fill me-1"></i>
            {{ $detail['explanation'] }}
          </div>
        @endif
      </div>

    </div>
  </div>
@endforeach

{{-- ══ CTA FINAL ══ --}}
<div class="text-center mt-4 py-4 px-3 eco-card card"
     style="background:linear-gradient(135deg,#f0f9f4,#e8f5ee);">
  @if($passed)
    <i class="bi bi-award-fill fs-2 mb-2" style="color:#f0a500;"></i>
    <h6 class="fw-bold" style="color:#1a2e1a;">¡Felicitaciones, aprobaste el curso!</h6>
    <p class="text-muted mb-3" style="font-size:.85rem;">
      Sigue aprendiendo y expandiendo tu impacto ambiental positivo.
    </p>
  @else
    <i class="bi bi-book-fill fs-2 mb-2" style="color:#006837;"></i>
    <h6 class="fw-bold" style="color:#1a2e1a;">¡Sigue practicando!</h6>
    <p class="text-muted mb-3" style="font-size:.85rem;">
      Revisa los módulos del curso e intenta la evaluación nuevamente.
    </p>
  @endif

  <div class="d-flex justify-content-center gap-2 flex-wrap">
    <a href="{{ route('courses.show', $course->id) }}"
       class="btn fw-semibold px-4"
       style="background:#006837;color:#fff;border-radius:8px;">
      <i class="bi bi-arrow-repeat me-2"></i>Volver al curso
    </a>
    <a href="{{ route('courses.index') }}"
       class="btn btn-outline-secondary fw-semibold px-4" style="border-radius:8px;">
      <i class="bi bi-collection me-2"></i>Ver más cursos
    </a>
  </div>
</div>

@endsection
