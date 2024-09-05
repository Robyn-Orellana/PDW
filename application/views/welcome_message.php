<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Monitoreo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- CSS es esta  parte va todo lo de el diseño -->
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
                            <div class="card-header">
                                Estación Nº <?php echo $estacion['numero_estacion']; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Cliente: <?php echo $estacion['nombre_cliente']; ?></h5>
                                <p class="card-text"><strong>Tiempo Solicitado:</strong> <?php echo $estacion['tiempo_solicitado'] ? $estacion['tiempo_solicitado'] . ' minutos' : 'No especificado'; ?></p>
                                <p class="card-text"><strong>Tipo de Tiempo:</strong> 
                                    <?php echo $estacion['tiempo_libre'] ? 'Tiempo Libre (Cronómetro)' : 'Tiempo Específico'; ?>
                                </p>
                                
                                <!-- Temporizador y Cronómetro -->
                                <div id="timer-<?php echo $estacion['numero_estacion']; ?>" class="timer" style="display: <?php echo $estacion['tiempo_libre'] ? 'none' : 'block'; ?>;">
                                    <strong>Temporizador:</strong> <span id="timer-time-<?php echo $estacion['numero_estacion']; ?>">00:00:00</span>
                                </div>
                                <div id="stopwatch-<?php echo $estacion['numero_estacion']; ?>" class="stopwatch" style="display: <?php echo $estacion['tiempo_libre'] ? 'block' : 'none'; ?>;">
                                    <strong>Cronómetro:</strong> <span id="stopwatch-time-<?php echo $estacion['numero_estacion']; ?>">00:00:00</span>
                                </div>

                                <!-- Botón para detener el tiempo -->
                                <button type="button" class="btn btn-warning mt-3 stop-button" data-estacion="<?php echo $estacion['numero_estacion']; ?>">Detener Tiempo</button>

                                <!-- Mostrar la tarifa calculada -->
                                <!--<p class="mt-3"><strong>Tarifa a Pagar:</strong> <span id="tarifa-<?php echo $estacion['numero_estacion']; ?>">$0.00</span></p>-->

                                <!-- Botón para eliminar la estación -->
                                <form method="post" action="<?php echo base_url('index.php/welcome/eliminar'); ?>" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta estación?');">
                                    <input type="hidden" name="numero_estacion" value="<?php echo $estacion['numero_estacion']; ?>">
                                <button type="submit" class="btn btn-danger mt-3">Eliminar Estación</button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay estaciones registradas.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        //no tocar ni mover esta parte>>
        // Asociar la funcionalidad de eliminación de tarjetas
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                let estacionId = this.getAttribute('data-estacion');
                
                fetch('<?php echo base_url('index.php/welcome/eliminar'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'numero_estacion=' + estacionId,
                })
                .then(response => response.text())
                .then(() => {
                    document.getElementById('card-estacion-' + estacionId).remove();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
        //no tocar ni mover<<


       // Función para detener el tiempo
       function detenerTiempo(estacionId) {
            const timerElement = document.getElementById('timer-time-' + estacionId);
            const stopwatchElement = document.getElementById('stopwatch-time-' + estacionId);
            if (timerElement) {
                // Detener el temporizador
                const timerInterval = parseInt(timerElement.dataset.interval, 10);
                if (!isNaN(timerInterval)) {
                    clearInterval(timerInterval);
                }
            } else if (stopwatchElement) {
                // Detener el cronómetro
                const stopwatchInterval = parseInt(stopwatchElement.dataset.interval, 10);
                if (!isNaN(stopwatchInterval)) {
                    clearInterval(stopwatchInterval);
                }
            }
        }

        // Asociar la funcionalidad a los botones de detener tiempo
        document.querySelectorAll('.stop-button').forEach(button => {
            button.addEventListener('click', function () {
                let estacionId = this.getAttribute('data-estacion');
                detenerTiempo(estacionId);
            });
        });

        // Inicializar temporizador y cronómetro
        <?php foreach ($estaciones as $estacion): ?>
            <?php if (!$estacion['tiempo_libre'] && $estacion['tiempo_solicitado']): ?>
                // Inicializar temporizador
                let endTime = new Date('<?php echo $estacion['hora_inicio']; ?>').getTime() + (<?php echo $estacion['tiempo_solicitado']; ?> * 60000);
                let timerInterval = setInterval(function () {
                    let now = new Date().getTime();
                    let timeLeft = endTime - now;
                    if (timeLeft < 0) timeLeft = 0;
                    let minutes = Math.floor(timeLeft / 60000);
                    let seconds = Math.floor((timeLeft % 60000) / 1000);
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    document.getElementById('timer-time-<?php echo $estacion['numero_estacion']; ?>').textContent = minutes + ":" + seconds;
                }, 1000);
                document.getElementById('timer-time-<?php echo $estacion['numero_estacion']; ?>').dataset.interval = timerInterval.toString();
            <?php elseif ($estacion['tiempo_libre']): ?>
                // Inicializar cronómetro
                let startTime = new Date('<?php echo $estacion['hora_inicio']; ?>').getTime();
                let stopwatchInterval = setInterval(function () {
                    let now = new Date().getTime();
                    let elapsed = now - startTime;
                    let hours = Math.floor(elapsed / (1000 * 60 * 60));
                    let minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((elapsed % (1000 * 60)) / 1000);
                    hours = hours < 10 ? "0" + hours : hours;
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;
                    document.getElementById('stopwatch-time-<?php echo $estacion['numero_estacion']; ?>').textContent = hours + ":" + minutes + ":" + seconds;
                }, 1000);
                document.getElementById('stopwatch-time-<?php echo $estacion['numero_estacion']; ?>').dataset.interval = stopwatchInterval.toString();
            <?php endif; ?>
        <?php endforeach; ?>

        //no se puede separar a un documento js porque tiene funciones php, que no permite ejecutar en js
       
    </script>
</body>
</html>
