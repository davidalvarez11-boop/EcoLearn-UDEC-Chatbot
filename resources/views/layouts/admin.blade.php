<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin · EcoLearn UDEC — @yield('page-title','Panel')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{--adm:#1a2636;--adm2:#243447;--adm-accent:#00c96b;--adm-pale:#e8f5ee;}
    body{font-family:'Inter',sans-serif;background:#f0f2f5;}

    #adm-sidebar{
      width:240px;min-height:100vh;background:var(--adm);
      position:fixed;top:0;left:0;display:flex;flex-direction:column;z-index:100;
    }
    #adm-sidebar .brand{padding:1.3rem 1.2rem .9rem;border-bottom:1px solid rgba(255,255,255,.1);}
    #adm-sidebar .brand h5{color:#fff;font-weight:700;margin:0;font-size:1rem;}
    #adm-sidebar .brand small{color:rgba(255,255,255,.45);font-size:.7rem;}

    #adm-sidebar .nav-link{
      color:rgba(255,255,255,.7);padding:.55rem 1.2rem;
      border-radius:6px;margin:2px 8px;font-size:.86rem;
      transition:background .2s,color .2s;
    }
    #adm-sidebar .nav-link:hover,#adm-sidebar .nav-link.active{
      background:rgba(0,201,107,.15);color:#00c96b;
    }
    #adm-sidebar .nav-link i{width:20px;}
    .adm-nav-section{
      padding:.5rem 1.2rem .2rem;font-size:.68rem;color:rgba(255,255,255,.35);
      letter-spacing:.8px;text-transform:uppercase;margin-top:.5rem;
    }
    .adm-sidebar-footer{
      margin-top:auto;padding:1rem;border-top:1px solid rgba(255,255,255,.1);
    }

    #adm-topbar{
      height:58px;background:#fff;border-bottom:1px solid #e2e8f0;
      display:flex;align-items:center;padding:0 1.5rem;
      position:sticky;top:0;z-index:99;
    }

    #adm-main{margin-left:240px;}
    #adm-content{padding:2rem 2.5rem;}

    .adm-stat-card{
      border:none;border-radius:12px;
      box-shadow:0 2px 12px rgba(0,0,0,.07);
      transition:box-shadow .25s,transform .25s;
    }
    .adm-stat-card:hover{box-shadow:0 6px 24px rgba(0,0,0,.12);transform:translateY(-2px);}

    .adm-table thead{background:#f8f9fa;font-size:.82rem;color:#6b7280;}
    .adm-table tbody tr{font-size:.88rem;}
    .adm-table tbody tr:hover{background:#f8fffe;}

    .form-label{font-size:.85rem;font-weight:600;color:#374151;}
    .form-control,.form-select{font-size:.88rem;border-radius:8px;}
    .form-control:focus,.form-select:focus{
      border-color:#006837;box-shadow:0 0 0 .2rem rgba(0,104,55,.15);
    }

    .module-form-card,.question-form-card{
      border:1px solid #d1e8d8;border-radius:12px;padding:1.25rem;
      background:#fafffe;margin-bottom:1rem;position:relative;
    }
    .remove-btn{
      position:absolute;top:.75rem;right:.75rem;
      width:28px;height:28px;border-radius:50%;
      background:#fdecea;border:none;color:#c0392b;
      display:flex;align-items:center;justify-content:center;cursor:pointer;
      font-size:.9rem;transition:background .2s;
    }
    .remove-btn:hover{background:#f5c6c6;}

    .badge-admin{
      background:rgba(0,201,107,.15);color:#00c96b;
      font-size:.72rem;font-weight:600;padding:.3rem .65rem;border-radius:20px;
    }

    @media (max-width: 768px) {
      #adm-sidebar { transform: translateX(-100%); }
      #adm-sidebar.open { transform: translateX(0); }
      #adm-main { margin-left: 0; }
    }
  </style>
</head>
<body>

<!-- ═══ SIDEBAR ═══ -->
<aside id="adm-sidebar">
  <div class="brand">
    <div class="d-flex align-items-center gap-2 mb-1">
      <i class="bi bi-shield-fill-check" style="color:#00c96b;"></i>
      <h5>EcoLearn Admin</h5>
    </div>
    <small>Panel de administración · UDEC</small>
  </div>

  <nav class="nav flex-column mt-2 flex-grow-1">
    <div class="adm-nav-section">Principal</div>
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="adm-nav-section">Contenido</div>
    <a href="{{ route('admin.courses.index') }}"
       class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
      <i class="bi bi-book"></i> Cursos
    </a>
    <a href="{{ route('admin.users.index') }}"
       class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <i class="bi bi-people"></i> Estudiantes
    </a>

    <div class="adm-nav-section">Plataforma</div>
    <a href="{{ route('courses.index') }}" class="nav-link" target="_blank">
      <i class="bi bi-eye"></i> Ver plataforma
    </a>
    <a href="{{ route('dashboard.dashboard') }}" class="nav-link">
      <i class="bi bi-house-door"></i> Dashboard alumno
    </a>
  </nav>

  <div class="adm-sidebar-footer">
    <div class="d-flex align-items-center gap-2 mb-2">
      <div class="rounded-circle d-flex align-items-center justify-content-center"
           style="width:32px;height:32px;background:#00c96b;flex-shrink:0;">
        <i class="bi bi-person-fill text-dark" style="font-size:.9rem;"></i>
      </div>
      <div>
        <div style="color:#fff;font-size:.8rem;font-weight:600;line-height:1.1;">
          {{ auth()->user()->name }}
        </div>
        <div style="font-size:.7rem;color:rgba(255,255,255,.45);">Administrador</div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="btn btn-sm w-100"
              style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);border:none;font-size:.8rem;">
        <i class="bi bi-box-arrow-left me-1"></i> Cerrar sesión
      </button>
    </form>
  </div>
</aside>

<!-- ═══ MAIN ═══ -->
<div id="adm-main">
  <header id="adm-topbar">
    <button class="btn btn-sm d-md-none me-3"
            onclick="document.getElementById('adm-sidebar').classList.toggle('open')">
      <i class="bi bi-list fs-5"></i>
    </button>
    <div>
      <span class="fw-semibold text-dark" style="font-size:.92rem;">@yield('page-title','Panel')</span>
      @hasSection('breadcrumb')
        <span class="text-muted mx-2" style="font-size:.85rem;">/</span>
        <span class="text-muted" style="font-size:.85rem;">@yield('breadcrumb')</span>
      @endif
    </div>
    <div class="ms-auto">
      <span class="badge-admin"><i class="bi bi-shield-check me-1"></i>Admin</span>
    </div>
  </header>

  <main id="adm-content">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Corrige los siguientes errores:</strong>
        <ul class="mb-0 mt-1 ps-3">
          @foreach($errors->all() as $e)
            <li style="font-size:.88rem;">{{ $e }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @yield('content')
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
