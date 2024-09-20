<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notificación</title>
    <link rel="stylesheet" href="<?php echo base_url('vendor/css/style3.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="btn-submit2">
    <a href="#" id="regresar-btn" class="btn btn-submit">REGRESAR</a>
    <button type="button" id="preview-alert" class="btn-submit">Previsualizar Notificación</button>
</div>

<div class="container">
    <h1>Editar Notificación</h1>

    <form action="<?php echo site_url('welcome/actualizarNotificacion'); ?>" method="post" class="form-notificacion">
        <input type="hidden" name="id" value="<?php echo isset($notificacion) ? $notificacion['id'] : ''; ?>">

        <!-- Selección de estación -->
        <label for="estacion_id">Estación:</label>
        <select name="id_estacion" id="estacion_id" required>
            <?php if (!empty($estaciones)): ?>
                <?php foreach ($estaciones as $estacion): ?>
                    <option value="<?php echo $estacion['id']; ?>" <?php echo isset($notificacion) && $notificacion['estacion_id'] == $estacion['id'] ? 'selected' : ''; ?>>
                        <?php echo $estacion['nombre_estacion']; ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay estaciones disponibles</option>
            <?php endif; ?>
        </select><br>

        <label for="nombrenotifi">Nombre de la notificación:</label>
        <input type="text" id="nombrenotifi" name="nombrenotifi" value="<?php echo isset($notificacion) ? $notificacion['nombrenotifi'] : ''; ?>" required><br>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo isset($notificacion) ? $notificacion['titulo'] : ''; ?>" required><br>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" required><?php echo isset($notificacion) ? $notificacion['mensaje'] : ''; ?></textarea><br>

        <label for="tipoAlerta">Tipo de Alerta:</label>
        <select id="tipoAlerta" name="tipoAlerta">
            <option value="icon" <?php echo isset($notificacion) && $notificacion['imageUrl'] == null ? 'selected' : ''; ?>>Ícono</option>
            <option value="image" <?php echo isset($notificacion) && $notificacion['imageUrl'] != null ? 'selected' : ''; ?>>Imagen</option>
        </select><br>

        <div id="imageFields" style="<?php echo isset($notificacion) && $notificacion['imageUrl'] != null ? 'display:block;' : 'display:none;'; ?>">
            <label for="imageUrl">URL de la imagen:</label>
            <input type="url" id="imageUrl" name="imageUrl" value="<?php echo isset($notificacion) ? $notificacion['imageUrl'] : ''; ?>"><br>

            <label for="imageWidth">Ancho de la imagen (px):</label>
            <input type="number" id="imageWidth" name="imageWidth" value="<?php echo isset($notificacion) ? $notificacion['imageWidth'] : 150; ?>"><br>

            <label for="imageHeight">Alto de la imagen (px):</label>
            <input type="number" id="imageHeight" name="imageHeight" value="<?php echo isset($notificacion) ? $notificacion['imageHeight'] : 150; ?>"><br>
        </div>

        <div id="iconFields" style="<?php echo isset($notificacion) && $notificacion['imageUrl'] == null ? 'display:block;' : 'display:none;'; ?>">
            <label for="icono">Ícono de Alerta:</label>
            <select id="icono" name="icono">
                <option value="success" <?php echo isset($notificacion) && $notificacion['imageUrl'] == null && $notificacion['colorFondo'] == 'success' ? 'selected' : ''; ?>>Éxito</option>
                <option value="error" <?php echo isset($notificacion) && $notificacion['imageUrl'] == null && $notificacion['colorFondo'] == 'error' ? 'selected' : ''; ?>>Error</option>
                <option value="warning" <?php echo isset($notificacion) && $notificacion['imageUrl'] == null && $notificacion['colorFondo'] == 'warning' ? 'selected' : ''; ?>>Advertencia</option>
                <option value="info" <?php echo isset($notificacion) && $notificacion['imageUrl'] == null && $notificacion['colorFondo'] == 'info' ? 'selected' : ''; ?>>Información</option>
                <option value="question" <?php echo isset($notificacion) && $notificacion['imageUrl'] == null && $notificacion['colorFondo'] == 'question' ? 'selected' : ''; ?>>Pregunta</option>
            </select><br>
        </div>

        <label for="colorFondo">Color de fondo (Hex):</label>
        <input type="color" id="colorFondo" name="colorFondo" value="<?php echo isset($notificacion) ? $notificacion['colorFondo'] : '#ffffff'; ?>" required><br>

        <label for="colorBoton">Color del botón de confirmación (Hex):</label>
        <input type="color" id="colorBoton" name="colorBoton" value="<?php echo isset($notificacion) ? $notificacion['colorBoton'] : '#3085d6'; ?>" required><br>

        <label for="intervalo">Intervalo de Tiempo (minutos):</label>
        <input type="number" id="intervalo" name="intervalo" min="1" value="<?php echo isset($notificacion) ? $notificacion['intervalo'] : ''; ?>" required><br>

        <input type="submit" value="Actualizar Notificación" class="btn-submit">
    </form>
</div>

<script>
// Mostrar/ocultar campos según el tipo de alerta seleccionado
document.getElementById('tipoAlerta').addEventListener('change', function() {
    if (this.value === 'image') {
        document.getElementById('imageFields').style.display = 'block';
        document.getElementById('iconFields').style.display = 'none';
    } else {
        document.getElementById('imageFields').style.display = 'none';
        document.getElementById('iconFields').style.display = 'block';
    }
});

// Previsualizar la notificación 
document.getElementById('preview-alert').addEventListener('click', function() {
    let tipoAlerta = document.getElementById('tipoAlerta').value;
    let options = {
        title: document.getElementById('titulo').value,
        text: document.getElementById('mensaje').value,
        background: document.getElementById('colorFondo').value,
        confirmButtonColor: document.getElementById('colorBoton').value
    };

    if (tipoAlerta === 'image') {
        options.imageUrl = document.getElementById('imageUrl').value;
        options.imageWidth = document.getElementById('imageWidth').value;
        options.imageHeight = document.getElementById('imageHeight').value;
    } else {
        options.icon = document.getElementById('icono').value;
    }

    Swal.fire(options);
});

// Funcionalidad del botón de regresar
document.getElementById('regresar-btn').addEventListener('click', function (e) {
    e.preventDefault(); // Evitar que el enlace redirija automáticamente

    Swal.fire({
        background: '#c7d1d5',
        title: "¿ESTÁS SEGURO?",
        text: "Estás a punto de regresar.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Continuar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?php echo base_url('index.php/welcome/notificacion'); ?>";
        }
    });
});
</script>

</body>
</html>
