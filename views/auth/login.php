<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/">

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu E-mail" name="email"/>
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password"/>
    </div>

    <input class="boton" type="submit" value="Iniciar Sesion"/>

</form>

<div class="acciones">
    <a href="/register">¿Aun no tienes una cuenta? Crear una</a>
    <a href="/forget">¿Olvidastes tu password?</a>
</div>