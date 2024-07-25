<?php foreach ($alertas as $key => $mensajes) : ?>

    <?php foreach ($mensajes as $mensaje) : ?>
        <div class="alerta <?= $key; ?>">
            <?= $mensaje; ?>
        </div>
    <?php endforeach; ?>

<?php endforeach; ?>