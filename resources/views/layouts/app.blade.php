<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Task Manager</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">

    <!-- Nombre -->
    <a class="navbar-brand" href="{{ route('dashboard.dashboard') }}">
      Task Manager
    </a>

    <!-- Logout correcto -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="btn btn-danger">Cerrar sesión</button>
    </form>

  </div>
</nav>

<div class="container mt-4">
  @yield('content')
</div>

</body>
</html>