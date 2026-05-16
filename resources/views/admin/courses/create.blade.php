@extends('layouts.admin')

@section('page-title', 'Cursos')
@section('breadcrumb', 'Crear nuevo curso')

@section('content')

<form method="POST" action="{{ route('admin.courses.store') }}" id="course-form">
@csrf

<div class="row g-3">

  {{-- ══ COLUMNA PRINCIPAL ══ --}}
  <div class="col-xl-8">

    {{-- INFO BÁSICA --}}
    <div class="adm-stat-card card p-4 mb-3">
      <h6 class="fw-bold mb-3" style="color:#1a2636;">
        <i class="bi bi-info-circle me-2" style="color:#006837;"></i>Información del curso
      </h6>

      <div class="mb-3">
        <label class="form-label">Título del curso *</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title') }}" placeholder="Ej: Energía solar y sostenibilidad" required>
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Descripción *</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                  rows="3" placeholder="Descripción breve del curso para los estudiantes..." required>{{ old('description') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-0">
        <label class="form-label">Resultado esperado *</label>
        <textarea name="expected_result" class="form-control @error('expected_result') is-invalid @enderror"
                  rows="2" placeholder="Al finalizar el curso, el estudiante será capaz de..." required>{{ old('expected_result') }}</textarea>
      </div>
    </div>

    {{-- ══ MÓDULOS ══ --}}
    <div class="adm-stat-card card p-4 mb-3">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0" style="color:#1a2636;">
          <i class="bi bi-grid-3x3-gap me-2" style="color:#006837;"></i>Módulos del curso
        </h6>
        <button type="button" class="btn btn-sm" id="add-module"
                style="background:#e8f5ee;color:#006837;border-radius:8px;font-size:.82rem;">
          <i class="bi bi-plus-circle me-1"></i> Agregar módulo
        </button>
      </div>

      <div id="modules-container"></div>
    </div>

    {{-- ══ EVALUACIÓN ══ --}}
    <div class="adm-stat-card card p-4 mb-3">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0" style="color:#1a2636;">
          <i class="bi bi-clipboard2-check me-2" style="color:#006837;"></i>Evaluación
        </h6>
        <button type="button" class="btn btn-sm" id="add-question"
                style="background:#e8f5ee;color:#006837;border-radius:8px;font-size:.82rem;">
          <i class="bi bi-plus-circle me-1"></i> Agregar pregunta
        </button>
      </div>

      <div class="row g-2 mb-3">
        <div class="col-md-6">
          <label class="form-label">Título de la evaluación</label>
          <input type="text" name="eval_title" class="form-control"
                 value="{{ old('eval_title','Evaluación final del curso') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Descripción</label>
          <input type="text" name="eval_description" class="form-control"
                 value="{{ old('eval_description','Responde las siguientes preguntas.') }}">
        </div>
      </div>

      <div id="questions-container"></div>
    </div>

  </div>

  {{-- ══ COLUMNA LATERAL ══ --}}
  <div class="col-xl-4">
    <div class="adm-stat-card card p-4 mb-3" style="position:sticky;top:80px;">
      <h6 class="fw-bold mb-3" style="color:#1a2636;">
        <i class="bi bi-send me-2" style="color:#006837;"></i>Publicar
      </h6>
      <p class="text-muted mb-3" style="font-size:.83rem;">
        El curso se publicará inmediatamente y estará disponible para todos los estudiantes.
      </p>
      <button type="submit" class="btn w-100 fw-semibold mb-2"
              style="background:#006837;color:#fff;border-radius:8px;">
        <i class="bi bi-cloud-upload-fill me-2"></i> Publicar curso
      </button>
      <a href="{{ route('admin.courses.index') }}"
         class="btn btn-outline-secondary w-100" style="border-radius:8px;font-size:.88rem;">
        Cancelar
      </a>

      <hr>
      <div id="course-summary" style="font-size:.8rem;color:#6b7280;">
        <div class="d-flex justify-content-between mb-1">
          <span>Módulos</span>
          <span id="count-modules" class="fw-semibold">0</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Preguntas</span>
          <span id="count-questions" class="fw-semibold">0</span>
        </div>
      </div>
    </div>
  </div>

</div>
</form>

@push('scripts')
<script>
// ── Counters ──
let modIdx = 0, qIdx = 0;
function updateCounts() {
  document.getElementById('count-modules').textContent =
    document.querySelectorAll('.module-form-card').length;
  document.getElementById('count-questions').textContent =
    document.querySelectorAll('.question-form-card').length;
}

// ══ MODULE TEMPLATE ══
function moduleHTML(i) {
  return `
  <div class="module-form-card" data-module="${i}">
    <button type="button" class="remove-btn" onclick="removeItem(this,'module-form-card')">
      <i class="bi bi-x"></i>
    </button>
    <div class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
      <i class="bi bi-grid-3x3-gap-fill me-1"></i>Módulo ${i+1}
    </div>
    <div class="row g-2">
      <div class="col-md-8">
        <label class="form-label">Título del módulo *</label>
        <input type="text" name="modules[${i}][title]" class="form-control"
               placeholder="Ej: Energía renovable en el hogar" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Ícono</label>
        <select name="modules[${i}][icon]" class="form-select">
          <option value="book">Libro</option>
          <option value="leaf">Hoja</option>
          <option value="recycle">Reciclaje</option>
          <option value="plug">Energía</option>
          <option value="laptop">Tecnología</option>
          <option value="sun">Solar</option>
          <option value="water">Agua</option>
          <option value="repeat">Circular</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">Contenido del módulo *</label>
        <textarea name="modules[${i}][content]" class="form-control" rows="4"
                  placeholder="Desarrollo del contenido educativo del módulo..." required></textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Puntos clave <small class="text-muted">(uno por línea, hasta 5)</small></label>
        <div id="kp-${i}">
          <input type="text" name="modules[${i}][key_points][]" class="form-control mb-1"
                 placeholder="Punto clave 1">
        </div>
        <button type="button" class="btn btn-sm mt-1"
                style="background:#f0f9f4;color:#006837;border-radius:6px;font-size:.78rem;"
                onclick="addKeyPoint(${i})">
          <i class="bi bi-plus me-1"></i>Punto clave
        </button>
      </div>
      <div class="col-md-4">
        <label class="form-label">Tipo de actividad</label>
        <input type="text" name="modules[${i}][activity_type]" class="form-control"
               placeholder="Ej: Reflexión práctica" value="Actividad práctica">
      </div>
      <div class="col-md-8">
        <label class="form-label">Descripción de la actividad</label>
        <textarea name="modules[${i}][activity_description]" class="form-control" rows="2"
                  placeholder="Describe la actividad que debe realizar el estudiante..."></textarea>
      </div>
    </div>
  </div>`;
}

// ══ QUESTION TEMPLATE ══
function questionHTML(i) {
  return `
  <div class="question-form-card" data-question="${i}">
    <button type="button" class="remove-btn" onclick="removeItem(this,'question-form-card')">
      <i class="bi bi-x"></i>
    </button>
    <div class="fw-semibold mb-2" style="color:#006837;font-size:.82rem;">
      <i class="bi bi-patch-question me-1"></i>Pregunta ${i+1}
    </div>
    <div class="mb-2">
      <label class="form-label">Enunciado *</label>
      <textarea name="questions[${i}][question]" class="form-control" rows="2"
                placeholder="Escribe aquí la pregunta..." required></textarea>
    </div>
    <div class="row g-2 mb-2">
      <div class="col-md-6">
        <label class="form-label">Opción A *</label>
        <input type="text" name="questions[${i}][option_a]" class="form-control"
               placeholder="Primera opción" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Opción B *</label>
        <input type="text" name="questions[${i}][option_b]" class="form-control"
               placeholder="Segunda opción" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Opción C *</label>
        <input type="text" name="questions[${i}][option_c]" class="form-control"
               placeholder="Tercera opción" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Opción D *</label>
        <input type="text" name="questions[${i}][option_d]" class="form-control"
               placeholder="Cuarta opción" required>
      </div>
    </div>
    <div class="row g-2">
      <div class="col-md-3">
        <label class="form-label">Respuesta correcta *</label>
        <select name="questions[${i}][correct]" class="form-select" required>
          <option value="">Selecciona</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select>
      </div>
      <div class="col-md-9">
        <label class="form-label">Explicación de la respuesta</label>
        <input type="text" name="questions[${i}][explanation]" class="form-control"
               placeholder="¿Por qué esta opción es la correcta?">
      </div>
    </div>
  </div>`;
}

// ── Helpers ──
function addKeyPoint(modIdx) {
  const container = document.getElementById(`kp-${modIdx}`);
  const inp = document.createElement('input');
  inp.type = 'text';
  inp.name = `modules[${modIdx}][key_points][]`;
  inp.className = 'form-control mb-1';
  inp.placeholder = 'Punto clave';
  container.appendChild(inp);
}

function removeItem(btn, cls) {
  btn.closest('.'+cls).remove();
  updateCounts();
}

// ── Bindings ──
document.getElementById('add-module').addEventListener('click', () => {
  document.getElementById('modules-container').insertAdjacentHTML('beforeend', moduleHTML(modIdx++));
  updateCounts();
});

document.getElementById('add-question').addEventListener('click', () => {
  document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHTML(qIdx++));
  updateCounts();
});

// ── Init with 1 module + 1 question ──
document.getElementById('add-module').click();
document.getElementById('add-question').click();
</script>
@endpush

@endsection
