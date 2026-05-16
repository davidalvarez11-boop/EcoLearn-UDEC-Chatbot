<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro - Universidad de Cundinamarca</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background: linear-gradient(135deg,#006837,#00a859);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.card{
    border-radius:15px;
}

.logo{
    width:80px;
}

</style>

</head>

<body>

<div class="container">
<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow-lg p-4">

<div class="text-center mb-3">
<img src="/logo-ucundinamarca.png" class="logo">
<h4 class="mt-2 text-success">Registro</h4>
</div>

@if ($errors->any())
<div class="alert alert-danger">
@foreach ($errors->all() as $error)
<p class="mb-0">{{ $error }}</p>
@endforeach
</div>
@endif

<form method="POST" action="{{ route('register.store') }}">
@csrf

<div class="mb-3">
<label class="form-label">Nombre</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-person"></i></span>
<input type="text" name="name" class="form-control" required>
</div>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-envelope"></i></span>
<input type="email" name="email" class="form-control" required>
</div>
</div>

<div class="mb-3">
<label class="form-label">Contraseña</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-lock"></i></span>
<input type="password" id="password" name="password" class="form-control" required>
<button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
<i class="bi bi-eye"></i>
</button>
</div>
</div>

<div class="mb-3">
<label class="form-label">Confirmar contraseña</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
<input type="password" name="password_confirmation" class="form-control" required>
</div>
</div>

<button class="btn btn-success w-100">Registrarse</button>

</form>

<div class="text-center mt-3">
<p>¿Ya tienes cuenta?</p>
<a href="{{ route('login') }}" class="text-success fw-bold">Ir a Login</a>
</div>

<div class="text-center mt-3 text-muted">
Sistema Académico | Universidad de Cundinamarca
</div>

</div>
</div>
</div>
</div>

<script>

function togglePassword(){
    const password = document.getElementById("password");
    password.type = password.type === "password" ? "text" : "password";
}

</script>

</body>
</html>