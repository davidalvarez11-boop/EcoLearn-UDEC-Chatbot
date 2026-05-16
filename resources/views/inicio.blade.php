<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>EcoLearn UDEC</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    font-family: Arial;
}

.hero{
    background: linear-gradient(135deg,#006837,#00a859);
    color:white;
    padding:100px 0;
}

.feature-icon{
    font-size:40px;
    color:#006837;
}

.footer{
    background:#006837;
    color:white;
    padding:20px;
}

</style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
<div class="container">

<a class="navbar-brand" href="#">
EcoLearn UDEC
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="{{ route('login') }}">Login</a>
</li>

<li class="nav-item">
<a class="nav-link" href="{{ route('register') }}">Registro</a>
</li>

<li class="nav-item">
<a class="nav-link" href="/contacto">Contacto</a>
</li>

</ul>

</div>

</div>
</nav>


<!-- HERO -->

<section class="hero text-center">

<div class="container">

<h1 class="display-4">EcoLearn UDEC</h1>

<p class="lead">
Plataforma educativa para fortalecer la educación ambiental
en la Universidad de Cundinamarca.
</p>

<a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">
Crear cuenta
</a>

<a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
Iniciar sesión
</a>

</div>

</section>


<!-- SECCION INFO -->

<section class="container py-5">

<div class="row text-center">

<div class="col-md-4">

<i class="bi bi-book feature-icon"></i>

<h4 class="mt-3">Aprendizaje</h4>

<p>
Accede a módulos educativos sobre sostenibilidad,
reciclaje y gestión de residuos.
</p>

</div>

<div class="col-md-4">

<i class="bi bi-bar-chart feature-icon"></i>

<h4 class="mt-3">Evaluaciones</h4>

<p>
Realiza cuestionarios para evaluar tus conocimientos
sobre educación ambiental.
</p>

</div>

<div class="col-md-4">

<i class="bi bi-globe feature-icon"></i>

<h4 class="mt-3">Sostenibilidad</h4>

<p>
Promovemos prácticas responsables para
cuidar el medio ambiente.
</p>

</div>

</div>

</section>


<!-- FOOTER -->

<footer class="footer text-center">

<p>
Sistema EcoLearn UDEC | Universidad de Cundinamarca
</p>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
<div id="chatbot-app"></div>

</body>
</html>