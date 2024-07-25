<h1 class="nombre-pagina">Panel de Administracion</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<h2>Buscar Citas</h2>
<div class="busqueda">

    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?= $fecha; ?>">
        </div>


    </form>

</div>

<?php 
    if ( count($citas) === 0 ) {
        echo '<h2>No hay Citas en esta fecha</h2>';
    }
?>

<div id="citas-admin">

    <ul class="citas">

        <?php foreach($citas as $key => $cita) : ?>

            <?php if($idCita !== $cita->id) : ?>
                <?php $total = 0; ?> <!-- Iniciamos total en 0 -->
                <li>
                    <p>ID: <span><?= $cita->id; ?></span></p>
                    <p>Hora: <span><?= $cita->hora; ?></span></p>
                    <p>Cliente: <span><?= $cita->cliente; ?></span></p>
                    <p>Email: <span><?= $cita->email; ?></span></p>
                    <p>Telefono: <span><?= $cita->telefono; ?></span></p>

                    <h3>Servicios</h3>


                    <?php $idCita = $cita->id; ?>

            <?php endif; ?> <!-- Fin de If -->

                    <?php $total += $cita->precio; ?> <!-- Sumarle el precio de cada servicio -->

                    <p><span><?= $cita->servicio . " $" . $cita->precio;  ?></span></p>

                <?php 
                    /* Para validar el actual y el proximo id */
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;
                ?>

                <?php if(esUltimo($actual, $proximo)) : ?>
                    <p class="total">Total: <span>$<?= $total; ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?= $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
                <?php endif; ?>
            

        <?php endforeach; ?> <!-- Fin de Foreach -->

    </ul>

</div>

<?php
        $script = "
            <script src='build/js/buscador.js'></script>
        ";
?>