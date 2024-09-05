<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Monitoreo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- en la etiqueta style va todo el CSS -->
    <style>
      
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
                    <div class="col-md-4 mb-3">
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

                                <!-- Botón para detener el tiempo y calcular la tarifa -->
                                <button type="button" class="btn btn-warning mt-3 stop-button" data-estacion="<?php echo $estacion['numero_estacion']; ?>">Detener Tiempo</button>

                                <!-- Mostrar la tarifa calculada -->
                                <p class="mt-3"><strong>Tarifa a Pagar:</strong> <span id="tarifa-<?php echo $estacion['numero_estacion']; ?>">$0.00</span></p>

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tarifaPorMinuto = 0.50; // Define la tarifa por minuto

            const botonesStop = document.querySelectorAll('.stop-button');

            botonesStop.forEach(button => {
                button.addEventListener('click', function () {
                    const estacionId = button.getAttribute('data-estacion');
                    stopTime(estacionId); // Detener y calcular tarifa al hacer clic en "Stop"
                });
            });

            // Función para detener el tiempo y calcular la tarifa
            function stopTime(estacionId) {
                const timerElement = document.getElementById('timer-time-' + estacionId);
                const stopwatchElement = document.getElementById('stopwatch-time-' + estacionId);
                let totalMinutos = 0;

                if (timerElement && timerElement.style.display !== 'none') {
                    // Temporizador - calcular el tiempo transcurrido
                    const [hours, minutes, seconds] = timerElement.textContent.split(':').map(Number);
                    totalMinutos = hours * 60 + minutes + seconds / 60;
                } else if (stopwatchElement && stopwatchElement.style.display !== 'none') {
                    // Cronómetro - calcular el tiempo transcurrido
                    const [hours, minutes, seconds] = stopwatchElement.textContent.split(':').map(Number);
                    totalMinutos = hours * 60 + minutes + seconds / 60;
                }

                // Calcular la tarifa
                const tarifa = totalMinutos * tarifaPorMinuto;
                document.getElementById('tarifa-' + estacionId).textContent = `$${tarifa.toFixed(2)}`;

                // Detener el intervalo para el temporizador o cronómetro
                clearInterval(window['timerInterval' + estacionId]);
            }

            // Función para actualizar el temporizador
            function updateTimer(timerId, duration, startTime, estacionId) {
                const endTime = new Date(startTime).getTime() + (duration * 60000); // Duración en milisegundos
                window['timerInterval' + estacionId] = setInterval(function () {
                    const now = new Date().getTime();
                    const timeLeft = endTime - now;
                    if (timeLeft < 0) {
                        clearInterval(window['timerInterval' + estacionId]);
                        stopTime(estacionId); // Calcular tarifa cuando llegue a 0
                    }
                    const hours = Math.floor(timeLeft / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                    document.getElementById(timerId).textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }, 1000);
            }

            // Función para actualizar el cronómetro
            function updateStopwatch(stopwatchId, startTime, estacionId) {
                const start = new Date(startTime).getTime();
                window['timerInterval' + estacionId] = setInterval(function () {
                    const now = new Date().getTime();
                    const elapsed = now - start;
                    const hours = Math.floor(elapsed / (1000 * 60 * 60));
                    const minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((elapsed % (1000 * 60)) / 1000);
                    document.getElementById(stopwatchId).textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }, 1000);
            }

            // Aplicar la función updateTimer o updateStopwatch para cada estación
            <?php foreach ($estaciones as $estacion): ?>
                <?php if (!$estacion['tiempo_libre'] && $estacion['tiempo_solicitado']): ?>
                    updateTimer('timer-time-<?php echo $estacion['numero_estacion']; ?>', <?php echo $estacion['tiempo_solicitado']; ?>, '<?php echo $estacion['hora_inicio']; ?>', '<?php echo $estacion['numero_estacion']; ?>');
                <?php elseif ($estacion['tiempo_libre']): ?>
                    updateStopwatch('stopwatch-time-<?php echo $estacion['numero_estacion']; ?>', '<?php echo $estacion['hora_inicio']; ?>', '<?php echo $estacion['numero_estacion']; ?>');
                <?php endif; ?>
            <?php endforeach; ?>
        });
    </script>
</body>
</html>
