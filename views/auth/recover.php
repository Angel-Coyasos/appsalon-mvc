<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if ($error) return; ?>

<form class="formulario" method="POST">

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password"/>
    </div>

    <input class="boton" type="submit" value="Guardar Nuevo Password"/>

</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? Incicia Sesion</a>
    <a href="/register">¿Aun no tienes una cuenta? Crear una</a>
</div>