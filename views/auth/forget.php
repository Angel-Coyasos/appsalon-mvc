<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuacions"</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/forget">

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu E-mail" name="email"/>
    </div>

    <input class="boton" type="submit" value="Recuperar Password"/>

</form>

<div class="acciones">
    <a href="/register">¿Aun no tienes una cuenta? Crear una</a>
    <a href="/">Ya tienes una cuenta? Incicia Sesion</a>
</div>