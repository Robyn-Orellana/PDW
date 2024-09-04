<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporizador de Café Internet</title>
    <link rel="stylesheet" href="<?php echo base_url('vendor/stint/css/styles.css'); ?>">

</head>
<body>  
    <div class="container">
        <h1>TEMPORIZADORES</h1>
        <div id="stations-container" class="stations-grid">
            <!-- Aquí se añadirán los temporizadores de las estaciones -->
        </div>
        <button id="add-station-btn" onclick="addStation()">Agregar Estación</button>
        <button id="stop-all-btn" onclick="stopAllTimers()">Detener Todos</button>
    </div>
    <script src="<?php echo base_url('vendor/stint/js/script.js'); ?>"></script>


</body>
</html>
