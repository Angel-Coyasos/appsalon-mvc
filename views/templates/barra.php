<div class="barra">
    <p>Hola: <?= $nombre ?? '';?></p>
    <a class="boton" href="/logout">Cerrar Sesion</a>
</div>

<?php if (isset($_SESSION['admin'])) : ?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
<?php endif; ?>
