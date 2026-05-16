@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')

{{-- ══ STATS ══ --}}
<div class="row g-3 mb-4">

  @php
    $cards = [
      ['label'=>'Estudiantes',   'value'=>$stats['users'],    'icon'=>'bi-people-fill',        'color'=>'#4f46e5','bg'=>'#eef2ff'],
      ['label'=>'Cursos',        'value'=>$stats['courses'],  'icon'=>'bi-book-fill',           'color'=>'#006837','bg'=>'#e8f5ee'],
      ['label'=>'Tareas',        'value'=>$stats['tasks'],    'icon'=>'bi-check2-square',       'color'=>'#f0a500','bg'=>'#fff8e1'],
      ['label'=>'Evaluaciones',  'value'=>$stats['attempts'], 'icon'=>'bi-clipboard2-check-fill','color'=>'#0ea5e9','bg'=>'#e0f2fe'],
    ];
  @endphp

  @foreach($cards as $card)
  <div class="col-sm-6 col-xl-3">
    <div class="adm-stat-card card p-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div style="width:44px;height:44px;background:{{ $card['bg'] }};border-radius:10px;
                    display:flex;align-items:center;justify-content:center;">
          <i class="bi {{ $card['icon'] }}" style="color:{{ $card['color'] }};font-size:1.25rem;"></i>
        </div>
      </div>
      <div class="fw-bold" style="font-size:2rem;color:#1a2e1a;line-height:1;">{{ $card['value'] }}</div>
      <div class="text-muted mt-1" style="font-size:.82rem;">{{ $card['label'] }}</div>
    </div>
  </div>
  @endforeach

</div>

<div class="row g-3">

  {{-- ══ ACCIONES RÁPIDAS ══ --}}
  <div class="col-xl-4">
    <div class="adm-stat-card card h-100 p-4">
      <h6 class="fw-bold mb-3" style="color:#1a2636;">
        <i class="bi bi-lightning-fill me-2" style="color:#f0a500;"></i>Acciones rápidas
      </h6>

      <a href="{{ route('admin.courses.create') }}"
         class="btn w-100 mb-2 d-flex align-items-center gap-2"
         style="background:#006837;color:#fff;border-radius:8px;font-size:.88rem;">
        <i class="bi bi-plus-circle-fill"></i> Crear nuevo curso
      </a>
      <a href="{{ route('admin.courses.index') }}"
         class="btn btn-outline-secondary w-100 mb-2 d-flex align-items-center gap-2"
         style="border-radius:8px;font-size:.88rem;">
        <i class="bi bi-collection"></i> Gestionar cursos
      </a>
      <a href="{{ route('admin.users.index') }}"
         class="btn btn-outline-secondary w-100 mb-2 d-flex align-items-center gap-2"
         style="border-radius:8px;font-size:.88rem;">
        <i class="bi bi-people"></i> Ver estudiantes
      </a>
      <a href="{{ route('courses.index') }}" target="_blank"
         class="btn w-100 d-flex align-items-center gap-2"
         style="background:#e8f5ee;color:#006837;border:1px solid #b8ddcb;border-radius:8px;font-size:.88rem;">
        <i class="bi bi-eye"></i> Ver plataforma como alumno
      </a>
    </div>
  </div>

  {{-- ══ ÚLTIMAS EVALUACIONES ══ --}}
  <div class="col-xl-8">
    <div class="adm-stat-card card h-100 p-4">
      <h6 class="fw-bold mb-3" style="color:#1a2636;">
        <i class="bi bi-clipboard2-check me-2" style="color:#006837;"></i>Últimas evaluaciones rendidas
      </h6>

      @if($recentAttempts->isEmpty())
        <p class="text-muted" style="font-size:.85rem;">Aún no hay evaluaciones rendidas.</p>
      @else
        <div class="table-responsive">
          <table class="table adm-table mb-0">
            <thead>
              <tr>
                <th>Estudiante</th>
                <th>Curso</th>
                <th>Puntaje</th>
                <th>Estado</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentAttempts as $att)
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:28px;height:28px;background:#e8f5ee;flex-shrink:0;">
                      <i class="bi bi-person-fill" style="color:#006837;font-size:.75rem;"></i>
                    </div>
                    {{ $att->user->name }}
                  </div>
                </td>
                <td>{{ Str::limit($att->course->title, 30) }}</td>
                <td>
                  <strong>{{ $att->score }}/{{ $att->total }}</strong>
                  <span class="text-muted ms-1" style="font-size:.8rem;">({{ $att->percentage() }}%)</span>
                </td>
                <td>
                  @if($att->passed())
                    <span class="badge" style="background:#e8f5ee;color:#006837;">Aprobado</span>
                  @else
                    <span class="badge" style="background:#fdecea;color:#c0392b;">No aprobado</span>
                  @endif
                </td>
                <td class="text-muted" style="font-size:.8rem;">
                  {{ $att->created_at->format('d/m/Y H:i') }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

</div>

@endsection
