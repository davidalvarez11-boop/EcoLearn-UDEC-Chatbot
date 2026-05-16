<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EcoLearn UDEC — @yield('page-title', 'Plataforma')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --eco-green:      #006837;
      --eco-green-light:#00924e;
      --eco-green-pale: #e8f5ee;
      --eco-accent:     #f0a500;
    }

    body { font-family: 'Inter', sans-serif; background:#f4f6f8; }

    /* ── SIDEBAR ── */
    #sidebar {
      width: 240px;
      min-height: 100vh;
      background: var(--eco-green);
      position: fixed;
      top: 0; left: 0;
      display: flex;
      flex-direction: column;
      z-index: 100;
      transition: transform .3s;
    }

    #sidebar .brand {
      padding: 1.4rem 1.2rem 1rem;
      border-bottom: 1px solid rgba(255,255,255,.15);
    }
    #sidebar .brand h5 { color:#fff; font-weight:700; margin:0; font-size:1.1rem; letter-spacing:.5px; }
    #sidebar .brand small { color:rgba(255,255,255,.65); font-size:.72rem; }

    #sidebar .nav-link {
      color: rgba(255,255,255,.8);
      padding: .6rem 1.2rem;
      border-radius: 6px;
      margin: 2px 8px;
      font-size: .88rem;
      transition: background .2s, color .2s;
    }
    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
      background: rgba(255,255,255,.15);
      color: #fff;
    }
    #sidebar .nav-link i { width: 20px; }

    #sidebar .sidebar-footer {
      margin-top: auto;
      padding: 1rem;
      border-top: 1px solid rgba(255,255,255,.15);
    }

    /* ── TOPBAR ── */
    #topbar {
      height: 60px;
      background: #fff;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      position: sticky;
      top: 0;
      z-index: 99;
    }

    /* ── MAIN CONTENT ── */
    #main-wrapper {
      margin-left: 240px;
    }

    #page-content {
      padding: 2rem 2.5rem;
    }

    /* ── BADGE NUMBERED ── */
    .module-badge {
      width: 36px; height: 36px;
      background: var(--eco-green);
      color: #fff;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: .85rem;
      flex-shrink: 0;
    }

    /* ── CARDS ── */
    .eco-card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0,0,0,.07);
      transition: box-shadow .25s, transform .25s;
    }
    .eco-card:hover {
      box-shadow: 0 6px 24px rgba(0,104,55,.15);
      transform: translateY(-2px);
    }

    /* ── COURSE HERO ── */
    .course-hero {
      background: linear-gradient(135deg, var(--eco-green) 0%, var(--eco-green-light) 100%);
      border-radius: 16px;
      padding: 2.5rem;
      color: #fff;
    }

    /* ── EVALUATION ── */
    .question-card {
      border-left: 4px solid var(--eco-green);
      border-radius: 0 10px 10px 0;
    }
    .option-item {
      padding: .5rem .75rem;
      border-radius: 6px;
      margin-bottom: .3rem;
      background: var(--eco-green-pale);
      font-size: .9rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .option-letter {
      width: 24px; height: 24px;
      background: var(--eco-green);
      color: #fff;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: .75rem; font-weight: 700;
      flex-shrink: 0;
    }

    /* ── ACTIVITY STRIP ── */
    .activity-strip {
      background: linear-gradient(90deg, #fff8e6, #fffdf5);
      border: 1px solid #f0a500;
      border-radius: 10px;
      padding: .9rem 1.1rem;
    }

    @media (max-width: 768px) {
      #sidebar { transform: translateX(-100%); }
      #sidebar.open { transform: translateX(0); }
      #main-wrapper { margin-left: 0; }
    }
  </style>
</head>
<body>

<!-- ═══════════ SIDEBAR ═══════════ -->
<aside id="sidebar">
  <div class="brand">
    <div class="d-flex align-items-center gap-2 mb-1">
      <i class="bi bi-leaf-fill text-white fs-5"></i>
      <h5>EcoLearn</h5>
    </div>
    <small>UDEC · Educación Ambiental</small>
  </div>

  <nav class="nav flex-column mt-2 flex-grow-1">
    <a href="{{ route('dashboard.dashboard') }}" class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
      <i class="bi bi-house-door"></i> Inicio
    </a>
    <a href="{{ route('courses.index') }}" class="nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
      <i class="bi bi-book"></i> Cursos
    </a>
    <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
      <i class="bi bi-check2-square"></i> Tareas
    </a>
    <a href="{{ route('progress.index') }}" class="nav-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
      <i class="bi bi-bar-chart"></i> Progreso
    </a>
    <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
      <i class="bi bi-person-circle"></i> Perfil
    </a>

    @if(auth()->user()->isAdmin())
    <div style="margin:8px 8px 2px;padding:.4rem .5rem;font-size:.68rem;color:rgba(255,255,255,.4);
                text-transform:uppercase;letter-spacing:.8px;">Administración</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link"
       style="color:#00c96b !important;">
      <i class="bi bi-shield-fill-check"></i> Panel Admin
    </a>
    @endif
  </nav>

  <div class="sidebar-footer">
    <div class="d-flex align-items-center gap-2 mb-2">
      <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
           style="width:32px;height:32px;flex-shrink:0;">
        <i class="bi bi-person-fill text-success" style="font-size:.9rem;"></i>
      </div>
      <div>
        <div class="text-white fw-600" style="font-size:.8rem;line-height:1.1;">
          {{ auth()->user()->name }}
        </div>
        <div style="font-size:.7rem;color:rgba(255,255,255,.6);">Estudiante</div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="btn btn-sm btn-outline-light w-100">
        <i class="bi bi-box-arrow-left me-1"></i> Cerrar sesión
      </button>
    </form>
  </div>
</aside>

<!-- ═══════════ MAIN WRAPPER ═══════════ -->
<div id="main-wrapper">

  <!-- TOPBAR -->
  <header id="topbar">
    <button class="btn btn-sm d-md-none me-3" onclick="document.getElementById('sidebar').classList.toggle('open')">
      <i class="bi bi-list fs-5"></i>
    </button>
    <div>
      <span class="fw-semibold text-dark" style="font-size:.95rem;">@yield('page-title', 'Panel')</span>
      @hasSection('breadcrumb')
        <span class="text-muted mx-2">/</span>
        <span class="text-muted" style="font-size:.85rem;">@yield('breadcrumb')</span>
      @endif
    </div>
    <div class="ms-auto d-flex align-items-center gap-2">
      <span class="badge rounded-pill" style="background:var(--eco-green-pale);color:var(--eco-green);font-size:.75rem;">
        <i class="bi bi-leaf-fill me-1"></i>Sostenibilidad
      </span>
    </div>
  </header>

  <!-- PAGE CONTENT -->
  <main id="page-content">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @yield('content')
  </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
