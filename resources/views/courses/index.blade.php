@extends('layouts.ecolearn')

@section('page-title', 'Cursos')

@section('content')

{{-- ── HEADER ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h4 class="fw-bold mb-1" style="color:#1a2e1a;">Cursos disponibles</h4>
    <p class="text-muted mb-0" style="font-size:.88rem;">
      Explora el catálogo de formación en sostenibilidad y educación ambiental
    </p>
  </div>
  <span class="badge rounded-pill px-3 py-2" style="background:#e8f5ee;color:#006837;font-size:.82rem;">
    <i class="bi bi-collection-fill me-1"></i>{{ $courses->count() }} curso{{ $courses->count() !== 1 ? 's' : '' }}
  </span>
</div>

{{-- ── GRID DE CURSOS ── --}}
@if($courses->isEmpty())
  <div class="text-center py-5">
    <i class="bi bi-book-half text-muted" style="font-size:3rem;"></i>
    <p class="text-muted mt-3">Aún no hay cursos disponibles.</p>
  </div>
@else
  <div class="row g-4">
    @foreach($courses as $course)

      {{-- Ícono según índice --}}
      @php
        $icons  = ['bi-laptop','bi-recycle','bi-droplet-half','bi-sun','bi-tree'];
        $colors = ['#006837','#00924e','#1a7a4a','#0d6b3f','#005c30'];
        $idx    = ($loop->index) % count($icons);
        $moduleCount = count($course->content['modules'] ?? []);
        $questionCount = count($course->content['evaluation']['questions'] ?? []);
      @endphp

      <div class="col-md-6 col-xl-4">
        <div class="eco-card card h-100">

          {{-- Banner superior --}}
          <div class="card-img-top d-flex align-items-center justify-content-center"
               style="height:130px;background:linear-gradient(135deg,{{ $colors[$idx] }},{{ $colors[($idx+1)%count($colors)] }});border-radius:12px 12px 0 0;">
            <i class="bi {{ $icons[$idx] }} text-white" style="font-size:3rem;opacity:.9;"></i>
          </div>

          <div class="card-body d-flex flex-column p-4">

            {{-- Badge categoría --}}
            <span class="badge mb-2 align-self-start"
                  style="background:#e8f5ee;color:#006837;font-size:.72rem;font-weight:600;">
              <i class="bi bi-leaf-fill me-1"></i>Educación Ambiental
            </span>

            <h5 class="fw-bold mb-2" style="color:#1a2e1a;font-size:1rem;line-height:1.4;">
              {{ $course->title }}
            </h5>

            <p class="text-muted mb-3" style="font-size:.85rem;flex-grow:1;line-height:1.6;">
              {{ Str::limit($course->description, 130) }}
            </p>

            {{-- Meta info --}}
            <div class="d-flex gap-3 mb-3">
              <span class="d-flex align-items-center gap-1 text-muted" style="font-size:.78rem;">
                <i class="bi bi-grid-3x3-gap-fill" style="color:#006837;"></i>
                {{ $moduleCount }} módulo{{ $moduleCount !== 1 ? 's' : '' }}
              </span>
              <span class="d-flex align-items-center gap-1 text-muted" style="font-size:.78rem;">
                <i class="bi bi-patch-question-fill" style="color:#f0a500;"></i>
                {{ $questionCount }} pregunta{{ $questionCount !== 1 ? 's' : '' }}
              </span>
            </div>

            {{-- CTA --}}
            <a href="{{ route('courses.show', $course->id) }}"
               class="btn w-100 fw-semibold"
               style="background:#006837;color:#fff;border-radius:8px;font-size:.88rem;">
              <i class="bi bi-play-circle-fill me-2"></i>Ver curso
            </a>

          </div>

        </div>
      </div>

    @endforeach
  </div>
@endif

@endsection
