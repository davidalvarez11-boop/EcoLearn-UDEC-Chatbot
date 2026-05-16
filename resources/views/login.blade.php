<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login - Universidad de Cundinamarca</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg,#006837,#00a859);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:0;
}

.login-container{
    background:white;
    padding:40px;
    width:360px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.logo{
    text-align:center;
    margin-bottom:15px;
}

.logo img{
    width:90px;
}

h1{
    text-align:center;
    color:#006837;
    margin-bottom:25px;
}

label{
    font-weight:bold;
    color:#333;
}

input{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:15px;
    border-radius:5px;
    border:1px solid #ccc;
}

input:focus{
    border-color:#006837;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#006837;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#004d29;
}

.error{
    background:#ffe5e5;
    color:#b30000;
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
}

.success{
    background:#e6ffed;
    color:#006622;
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
}

.register{
    text-align:center;
    margin-top:15px;
}

.register a{
    color:#006837;
    text-decoration:none;
    font-weight:bold;
}

.register a:hover{
    text-decoration:underline;
}

.footer{
    text-align:center;
    font-size:12px;
    margin-top:20px;
    color:#777;
}

</style>
</head>

<body>

<div class="login-container">

<div class="logo">
<img src="/logo-ucundinamarca.png" alt="Universidad de Cundinamarca">
</div>

<h1>Iniciar Sesión</h1>

{{-- Mostrar errores --}}
@if ($errors->any())
<div class="error">
@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach
</div>
@endif

{{-- Mensaje éxito --}}
@if (session('success'))
<div class="success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('login.store') }}">
@csrf

<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required>

<label>Contraseña</label>
<input type="password" name="password" required>

<button type="submit">Ingresar</button>

</form>

<div class="register">
<p>¿No tienes cuenta?</p>
<a href="{{ route('register') }}">Crear cuenta</a>
</div>

<div class="footer">
Sistema Académico | Universidad de Cundinamarca
</div>

</div>

</body>
</html>