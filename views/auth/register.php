<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/register">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu Nombre" name="nombre" value="<?= s($usuario->nombre); ?>"/>
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu Apellido" name="apellido" value="<?= s($usuario->apellido); ?>"/>
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" placeholder="Tu Telefono" name="telefono" value="<?= s($usuario->telefono); ?>"/>
    </div>

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu E-mail" name="email" value="<?= s($usuario->email); ?>"/>
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password"/>
    </div>

    <input class="boton" type="submit" value="Crear Cuenta"/>

</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Incicia Sesion</a>
    <a href="/forget">¿Olvidastes tu password?</a>
</div>