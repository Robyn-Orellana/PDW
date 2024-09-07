<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Monitoreo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        .card {
            margin-bottom: 20px;
        }
        .timer, .stopwatch {
            font-size: 1.5rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Botón para agregar una nueva estación -->
        <a href="<?php echo base_url('index.php/welcome/agregar'); ?>" class="btn btn-success mb-3">Agregar Nueva Estación</a>
        
        <!-- Contenedor para las tarjetas de estaciones -->
        <div class="row">
            <?php if (!empty($estaciones)): ?>
                <?php foreach ($estaciones as $estacion): ?>
                    <div id="card-estacion-<?php echo $estacion['numero_estacion']; ?>" class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-header">Estación Nº <?php echo $estacion['numero_estacion']; ?></div>
                            <div class="card-body">
                                <div class="card-header">Nombre de la Estación: <?php echo $estacion['nombre_estacion']; ?></div>
                                <div class="card-body">
                                    <!-- Elemento para mostrar el contador -->
                                    <div class="timer">00h 00m 00s</div>
                                <div class="card-body">
                                    <!-- Botón para iniciar el tiempo -->
                                    <a href="<?php echo base_url('index.php/welcome/iniciar_tiempo/' . $estacion['id']); ?>" class="btn btn-primary">Iniciar Tiempo</a>
                                
                                    <!-- Botón para detener el tiempo si hay tiempo activo -->
                                    <?php if ($estacion['tiempo_activo']): ?>
                                        <a href="<?php echo base_url('index.php/welcome/detener_tiempo/' . $estacion['id']); ?>" class="btn btn-warning mt-2">Detener Tiempo</a>
                                        
                                    <?php endif; ?>
                                    
                                    <!-- Botón para eliminar la estación -->
                                    <a href="<?php echo base_url('index.php/welcome/eliminar/' . $estacion['id']); ?>" class="btn btn-danger mt-2">Eliminar Estación</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay estaciones registradas.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>

