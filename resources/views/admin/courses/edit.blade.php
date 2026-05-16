@extends('layouts.admin')

@section('page-title', 'Cursos')
@section('breadcrumb', 'Editar: ' . Str::limit($course->title, 40))

@section('content')

@php
  $modules   = $course->content['modules']              ?? [];
  $evaluation= $course->content['evaluation']           ?? [];
  $questions = $evaluation['questions']                 ?? [];
  $expected  = $course->content['expected_result']      ?? '';
  $evalTitle = $evaluation['title']                     ?? 'Evaluación final del curso';
  $evalDesc  = $evaluation['description']               ?? '';

  $iconReverse = [
    'bi-laptop'      => 'laptop',
    'bi-recycle'     => 'recycle',
    'bi-leaf-fill'   => 'leaf',
    'bi-plug-fill'   => 'plug',
    'bi-book-fill'   => 'book',
    'bi-sun-fill'    => 'sun',
    'bi-droplet-half'=> 'water',
    'bi-arrow-repeat'=> 'repeat',
  ];
@endphp

<form method="POST" action="{{ route('admin.courses.update', $course->id) }}" id="course-form">
@csrf @method('PUT')

<div class="row g-3">

  <div class="col-xl-8">

    {{-- INFO BÁSICA --}}
    <div class="adm-stat-card card p-4 mb-3">
      <h6 class="fw-bold mb-3" style="color:#1a2636;">
        <i class="bi bi-info-circle me-2" style="color:#006837;"></i>Información del curso
      </h6>
      <div class="mb-3">
        <label class="form-label">Título *</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $course->title) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Descripción *</label>
        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $course->description) }}</textarea>
      </div>
      <div>
        <label class="form-label">Resultado esperado *</label>
        <textarea name="expected_result" class="form-control" rows="2" required>{{ old('expected_result', $expected) }}</textarea>
      </div>
    </div>

    {{-- MÓDULOS --}}
    <div class="adm-stat-card card p-4 mb-3">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0" style="color:#1a2636;">
          <i class="bi bi-grid-3x3-gap me-2" style="color:#006837;"></i>Módulos
        </h6>
        <button type="button" class="btn btn-sm" id="add-module"
                style="background:#e8f5ee;color:#006837;border-radius:8px;font-size:.82rem;">
          <i class="bi bi-plus-circle me-1"></i>Agregar módulo
        </button>
      </div>
      <div id="modules-container">
        @foreach($modules as $i => $mod)
        <div class="module-form-card" data-module="{{ $i }}">
          <button type="button" class="remove-btn" onclick="removeItem(this,'module-form-card')">
            <i class="bi bi-x"></i>
          </button>
          <div class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
            <i class="bi bi-grid-3x3-gap-fill me-1"></i>Módulo {{ $i+1 }}
          </div>
          <div class="row g-2">
            <div class="col-md-8">
              <label class="form-label">Título *</label>
              <input type="text" name="modules[{{ $i }}][title]" class="form-control"
                     value="{{ $mod['title'] }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Ícono</label>
              <select name="modules[{{ $i }}][icon]" class="form-select">
                @php $selIcon = $iconReverse[$mod['icon'] ?? ''] ?? 'book'; @endphp
                @foreach(['book'=>'Libro','leaf'=>'Hoja','recycle'=>'Reciclaje','plug'=>'Energía','laptop'=>'Tecnología','sun'=>'Solar','water'=>'Agua','repeat'=>'Circular'] as $k=>$v)
                  <option value="{{ $k }}" {{ $selIcon===$k?'selected':'' }}>{{ $v }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Contenido *</label>
              <textarea name="modules[{{ $i }}][content]" class="form-control" rows="4" required>{{ $mod['content'] }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Puntos clave</label>
              <div id="kp-edit-{{ $i }}">
                @foreach($mod['key_points'] ?? [] as $kp)
                  <input type="text" name="modules[{{ $i }}][key_points][]"
                         class="form-control mb-1" value="{{ $kp }}">
                @endforeach
                @if(empty($mod['key_points']))
                  <input type="text" name="modules[{{ $i }}][key_points][]" class="form-control mb-1" placeholder="Punto clave 1">
                @endif
              </div>
              <button type="button" class="btn btn-sm mt-1"
                      style="background:#f0f9f4;color:#006837;border-radius:6px;font-size:.78rem;"
                      onclick="addKeyPointEdit({{ $i }})">
                <i class="bi bi-plus me-1"></i>Punto clave
              </button>
            </div>
            <div class="col-md-4">
              <label class="form-label">Tipo actividad</label>
              <input type="text" name="modules[{{ $i }}][activity_type]" class="form-control"
                     value="{{ $mod['activity']['type'] ?? 'Actividad práctica' }}">
            </div>
            <div class="col-md-8">
              <label class="form-label">Descripción actividad</label>
              <textarea name="modules[{{ $i }}][activity_description]" class="form-control" rows="2">{{ $mod['activity']['description'] ?? '' }}</textarea>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- EVALUACIÓN --}}
    <div class="adm-stat-card card p-4 mb-3">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0" style="color:#1a2636;">
          <i class="bi bi-clipboard2-check me-2" style="color:#006837;"></i>Evaluación
        </h6>
        <button type="button" class="btn btn-sm" id="add-question"
                style="background:#e8f5ee;color:#006837;border-radius:8px;font-size:.82rem;">
          <i class="bi bi-plus-circle me-1"></i>Agregar pregunta
        </button>
      </div>
      <div class="row g-2 mb-3">
        <div class="col-md-6">
          <label class="form-label">Título evaluación</label>
          <input type="text" name="eval_title" class="form-control" value="{{ old('eval_title', $evalTitle) }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Descripción</label>
          <input type="text" name="eval_description" class="form-control" value="{{ old('eval_description', $evalDesc) }}">
        </div>
      </div>
      <div id="questions-container">
        @foreach($questions as $i => $q)
        <div class="question-form-card" data-question="{{ $i }}">
          <button type="button" class="remove-btn" onclick="removeItem(this,'question-form-card')">
            <i class="bi bi-x"></i>
          </button>
          <div class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
            <i class="bi bi-patch-question me-1"></i>Pregunta {{ $i+1 }}
          </div>
          <div class="mb-2">
            <label class="form-label">Enunciado *</label>
            <textarea name="questions[{{ $i }}][question]" class="form-control" rows="2" required>{{ $q['question'] }}</textarea>
          </div>
          <div class="row g-2 mb-2">
            @foreach(['a','b','c','d'] as $letter)
            <div class="col-md-6">
              <label class="form-label">Opción {{ strtoupper($letter) }} *</label>
              <input type="text" name="questions[{{ $i }}][option_{{ $letter }}]" class="form-control"
                     value="{{ $q['options'][strtoupper($letter)] ?? '' }}" required>
            </div>
            @endforeach
          </div>
          <div class="row g-2">
            <div class="col-md-3">
              <label class="form-label">Correcta *</label>
              <select name="questions[{{ $i }}][correct]" class="form-select" required>
                @foreach(['A','B','C','D'] as $l)
                  <option value="{{ $l }}" {{ ($q['correct']===$l)?'selected':'' }}>{{ $l }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-9">
              <label class="form-label">Explicación</label>
              <input type="text" name="questions[{{ $i }}][explanation]" class="form-control"
                     value="{{ $q['explanation'] ?? '' }}">
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>

  {{-- SIDEBAR --}}
  <div class="col-xl-4">
    <div class="adm-stat-card card p-4 mb-3" style="position:sticky;top:80px;">
      <h6 class="fw-bold mb-3" style="color:#1a2636;">
        <i class="bi bi-pencil-square me-2" style="color:#006837;"></i>Guardar cambios
      </h6>
      <button type="submit" class="btn w-100 fw-semibold mb-2"
              style="background:#006837;color:#fff;border-radius:8px;">
        <i class="bi bi-check2-circle me-2"></i> Guardar cambios
      </button>
      <a href="{{ route('admin.courses.index') }}"
         class="btn btn-outline-secondary w-100" style="border-radius:8px;font-size:.88rem;">
        Cancelar
      </a>
      <hr>
      <div style="font-size:.8rem;color:#6b7280;">
        <div class="d-flex justify-content-between mb-1">
          <span>Módulos actuales</span>
          <span class="fw-semibold">{{ count($modules) }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Preguntas actuales</span>
          <span class="fw-semibold">{{ count($questions) }}</span>
        </div>
      </div>
    </div>
  </div>

</div>
</form>

@push('scripts')
<script>
let modIdx = {{ count($modules) }};
let qIdx   = {{ count($questions) }};

function moduleHTML(i) {
  return `
  <div class="module-form-card" data-module="${i}">
    <button type="button" class="remove-btn" onclick="removeItem(this,'module-form-card')">
      <i class="bi bi-x"></i>
    </button>
    <div class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
      <i class="bi bi-grid-3x3-gap-fill me-1"></i>Módulo Nuevo
    </div>
    <div class="row g-2">
      <div class="col-md-8">
        <label class="form-label">Título *</label>
        <input type="text" name="modules[${i}][title]" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Ícono</label>
        <select name="modules[${i}][icon]" class="form-select">
          <option value="book">Libro</option><option value="leaf">Hoja</option>
          <option value="recycle">Reciclaje</option><option value="plug">Energía</option>
          <option value="laptop">Tecnología</option><option value="sun">Solar</option>
          <option value="water">Agua</option><option value="repeat">Circular</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">Contenido *</label>
        <textarea name="modules[${i}][content]" class="form-control" rows="4" required></textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Puntos clave</label>
        <div id="kp-edit-${i}">
          <input type="text" name="modules[${i}][key_points][]" class="form-control mb-1">
        </div>
        <button type="button" class="btn btn-sm mt-1"
                style="background:#f0f9f4;color:#006837;border-radius:6px;font-size:.78rem;"
                onclick="addKeyPointEdit(${i})">
          <i class="bi bi-plus me-1"></i>Punto clave
        </button>
      </div>
      <div class="col-md-4">
        <label class="form-label">Tipo actividad</label>
        <input type="text" name="modules[${i}][activity_type]" class="form-control" value="Actividad práctica">
      </div>
      <div class="col-md-8">
        <label class="form-label">Descripción actividad</label>
        <textarea name="modules[${i}][activity_description]" class="form-control" rows="2"></textarea>
      </div>
    </div>
  </div>`;
}

function questionHTML(i) {
  return `
  <div class="question-form-card" data-question="${i}">
    <button type="button" class="remove-btn" onclick="removeItem(this,'question-form-card')">
      <i class="bi bi-x"></i>
    </button>
    <div class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
      <i class="bi bi-patch-question me-1"></i>Nueva pregunta
    </div>
    <div class="mb-2">
      <label class="form-label">Enunciado *</label>
      <textarea name="questions[${i}][question]" class="form-control" rows="2" required></textarea>
    </div>
    <div class="row g-2 mb-2">
      ${['a','b','c','d'].map(l => `
      <div class="col-md-6">
        <label class="form-label">Opción ${l.toUpperCase()} *</label>
        <input type="text" name="questions[${i}][option_${l}]" class="form-control" required>
      </div>`).join('')}
    </div>
    <div class="row g-2">
      <div class="col-md-3">
        <label class="form-label">Correcta *</label>
        <select name="questions[${i}][correct]" class="form-select" required>
          <option value="">Selecciona</option>
          <option>A</option><option>B</option><option>C</option><option>D</option>
        </select>
      </div>
      <div class="col-md-9">
        <label class="form-label">Explicación</label>
        <input type="text" name="questions[${i}][explanation]" class="form-control">
      </div>
    </div>
  </div>`;
}

function addKeyPointEdit(idx) {
  const c = document.getElementById(`kp-edit-${idx}`);
  if (!c) return;
  const inp = document.createElement('input');
  inp.type='text'; inp.className='form-control mb-1';
  inp.name=`modules[${idx}][key_points][]`;
  c.appendChild(inp);
}

function removeItem(btn, cls) { btn.closest('.'+cls).remove(); }

document.getElementById('add-module').addEventListener('click', () => {
  document.getElementById('modules-container').insertAdjacentHTML('beforeend', moduleHTML(modIdx++));
});
document.getElementById('add-question').addEventListener('click', () => {
  document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHTML(qIdx++));
});
</script>
@endpush

@endsection
