<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Notificación</title>
    <!-- Enlace al archivo CSS externo -->
    <link rel="stylesheet" href="<?php echo base_url('vendor/css/style3.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="btn-submit2">
<a href="#" id="regresar-btn" class="btn btn-submit">REGRESAR</a>

<button type="button" id="preview-alert" class="btn-submit">Previsualizar Notificación</button>

</div>
    

           

    <div class="container">


                <h1>Crear Nueva Notificación</h1>
                
                
                <!-- Formulario para crear notificación -->
                <form action="<?php echo site_url('welcome/guardarnotificacion'); ?>" method="post" class="form-notificacion">
                    <!-- Selección de estación -->
                    <label for="estacion_id">Estación:</label>
                    <select name="estacion_id" id="estacion_id" required>
                        <?php foreach ($estaciones as $estacion): ?>
                            <option value="<?php echo $estacion['id']; ?>"><?php echo $estacion['nombre_estacion']; ?></option>
                        <?php endforeach; ?>
                    </select><br>

                    <!-- Campo para el texto alternativo de la imagen -->
                    <label for="nombrenotifi">Nombre de la notificacion:</label>
                    <input type="text" id="nombrenotifi" name="nombrenotifi" required><br>  
                    
                    <!-- Campo para el título -->
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required><br>

                    <!-- Campo para el mensaje -->
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea><br>

                    <!-- Campo para la URL de la imagen -->
                    <label for="imageUrl">URL de la imagen:</label>
                    <input type="url" id="imageUrl" name="imageUrl"><br>

                    <!-- Campo para el ancho de la imagen -->
                    <label for="imageWidth">Ancho de la imagen (px):</label>
                    <input type="number" id="imageWidth" name="imageWidth" value="0" required><br>

                    <!-- Campo para el alto de la imagen -->
                    <label for="imageHeight">Alto de la imagen (px):</label>
                    <input type="number" id="imageHeight" name="imageHeight" value="0" required><br>

                

                   <!-- Campo para el color de fondo -->
            <label for="colorFondo">Color de fondo (Hex):</label>
            <input type="color" id="colorFondo" name="colorFondo" value="#ffffff" required><br>

            <!-- Campo para el color del botón -->
            <label for="colorBoton">Color del botón de confirmación (Hex):</label>
            <input type="color" id="colorBoton" name="colorBoton" value="#3085d6" required><br>


                    <!-- Botón para enviar el formulario -->
                    <input type="submit" value="Crear Notificación" class="btn-submit">
                </form>
                
            
    </div>

    <script>
      


//para usar el boton de regreso a la lista de notificaciones
    document.getElementById('regresar-btn').addEventListener('click', function (e) {
        e.preventDefault(); // Evitar que el enlace redirija automáticamente

        Swal.fire({
            background: '#c7d1d5', // Cambia el color de fondo
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
                // Redirigir al usuario a la URL después de confirmar
                window.location.href = "<?php echo base_url('index.php/welcome/notificacion'); ?>";
            }
        });
    });
</script>



<script>
    document.getElementById('preview-alert').addEventListener('click', function() {
        Swal.fire({
            idestacion: document.getElementById('estacion_id').value,
            title: document.getElementById('titulo').value,
            text: document.getElementById('mensaje').value,
            imageUrl: document.getElementById('imageUrl').value,
            imageWidth: document.getElementById('imageWidth').value,
            imageHeight: document.getElementById('imageHeight').value,
            imageAlt: document.getElementById('nombrenotifi').value,
            background: document.getElementById('colorFondo').value,
            confirmButtonColor: document.getElementById('colorBoton').value
        });
    });
</script>



</body>
</html>

