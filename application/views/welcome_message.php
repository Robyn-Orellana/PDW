<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Monitoreo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('vendor/css/styles.css?v=1.0'); ?>">

</head>

<body>
    <div class="container mt-5">
        <!-- Botón para agregar una nueva estación -->
        <a href="<?php echo base_url('index.php/welcome/agregar'); ?>" class="btn btn-success mb-3">Agregar Estación</a>
        
        <!-- Contenedor para las tarjetas de estaciones -->
        <div class="row">
            <?php if (!empty($estaciones)): ?>
                <?php foreach ($estaciones as $estacion): ?>
                    <div id="card-estacion-<?php echo $estacion['numero_estacion']; ?>" class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-header">
                                Estación Nº <?php echo $estacion['numero_estacion']; ?>
                                <!-- Botón para eliminar la estación con imagen -->
                                <button onclick="confirmarEliminacion(<?php echo $estacion['id']; ?>)" class="btn btn-danger">
                                    <img src="<?php echo base_url('vendor/imgs/elim.png'); ?>" alt="Eliminar">
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="card-title">Nombre de la Estación: <?php echo $estacion['nombre_estacion']; ?></div>
                                <div class="timer" id="timer-<?php echo $estacion['id']; ?>">00h 00m 00s</div>
                                
                                <!-- Input para ingresar la duración de la cuenta regresiva -->
                                <input type="number" id="duracion-<?php echo $estacion['id']; ?>" placeholder="Duración en segundos" class="form-control mb-2">
                                
                                <!-- Botones para controlar el tiempo -->
                                <div class="btn-group">
                                    <button onclick="startCountdown(<?php echo $estacion['id']; ?>)" class="btn btn-primary">Iniciar Tiempo Definido</button>
                                    <button onclick="startNormalTimer(<?php echo $estacion['id']; ?>)" class="btn btn-success">Iniciar Tiempo Normal</button>
                                </div>
                                <div class="btn-group mt-2">
                                    <button onclick="resetAndStartTimer(<?php echo $estacion['id']; ?>)" class="btn btn-secondary">Reiniciar</button>
                                    <button onclick="stopTimer(<?php echo $estacion['id']; ?>)" class="btn btn-warning">Detener</button>
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
    <script>

        let countdownIntervals = {}; // Para cronómetros regresivos
        let normalTimerIntervals = {}; // Para cronómetros normales
        let countdownEndTimes = {};  // Para hora de finalización de cronómetros regresivos
        let normalTimerEndTimes = {}; // Para hora de inicio de cronómetros normales

        // Confirmar eliminación de estación
        function confirmarEliminacion(estacionId) {
            const confirmar = confirm("¿Estás seguro de que quieres eliminar esta estación?");
            if (confirmar) {
                // Redirigir al usuario para eliminar la estación
                window.location.href = "<?php echo base_url('index.php/welcome/eliminar/'); ?>" + estacionId;
            } else {
                // Si el usuario cancela, no hacer nada
                console.log("Eliminación cancelada");
            }
        }

        // Iniciar cuenta regresiva 
        function startCountdown(estacionId) {
            let duracion = document.getElementById(`duracion-${estacionId}`).value; // Duración ingresada

            if (duracion > 0) {
                // Enviar solicitud AJAX al servidor para iniciar el tiempo
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo base_url('index.php/welcome/iniciar_tiempo_regresivo'); ?>", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Calcular la hora en que termina la cuenta regresiva
                            countdownEndTimes[estacionId] = Date.now() + duracion * 1000;
                            countdownIntervals[estacionId] = setInterval(() => updateCountdown(estacionId), 1000);
                            alert(response.message); // Mensaje de éxito
                        } else {
                            alert(response.message); // Mensaje de error
                        }
                    }
                };
                xhr.send("estacion_id=" + estacionId + "&duracion=" + duracion);
            } else {
                alert("Por favor, ingresa una duración válida.");
            }
        }

        //para reiniciar
        function resetAndStartTimer(estacionId) {
            // Detener cualquier intervalo en curso
            if (countdownIntervals[estacionId]) {
                clearInterval(countdownIntervals[estacionId]);
            }

            // Enviar solicitud AJAX al servidor para reiniciar el tiempo
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo base_url('index.php/welcome/reiniciar_tiempo'); ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Reiniciar la visualización del cronómetro a "00h 00m 00s"
                        document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
                        document.getElementById(`duracion-${estacionId}`).value = ''; // Limpiar input de duración
                        delete countdownEndTimes[estacionId]; // Limpiar hora de finalización

                        alert(response.message); // Mensaje de éxito

                        // Iniciar automáticamente después de reiniciar
                        startNormalTimer(estacionId); // Inicia el cronómetro de tiempo libre
                    } else {
                        alert(response.message); // Mensaje de error
                    }
                }
            };
            xhr.send("estacion_id=" + estacionId);
        }

        // Detener tiempo
        function stopTimer(estacionId) {
            if (countdownIntervals[estacionId]) {
                clearInterval(countdownIntervals[estacionId]);

                // Enviar solicitud AJAX al servidor para detener el tiempo
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo base_url('index.php/welcome/detener_tiempo_regresivo'); ?>", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            delete countdownIntervals[estacionId]; // Limpiar el intervalo en frontend
                            alert(response.message); // Mensaje de éxito
                        } else {
                            alert(response.message); // Mensaje de error
                        }
                    }
                };
                xhr.send("estacion_id=" + estacionId);
            }
        }

        // Actualizar el temporizador de cuenta regresiva en la pantalla
        function updateCountdown(estacionId) {
            const now = Date.now();
            const remainingTime = countdownEndTimes[estacionId] - now;

            if (remainingTime <= 0) {
                clearInterval(countdownIntervals[estacionId]);
                document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
                
                // Cuando la cuenta regresiva llega a cero, enviar solicitud AJAX para detener el tiempo
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo base_url('index.php/welcome/detener_tiempo_regresivo'); ?>", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert("Tiempo finalizado y detenido automáticamente");
                        } else {
                            alert("Error al detener el tiempo: " + response.message);
                        }
                    }   
                };
                xhr.send("estacion_id=" + estacionId);

            } else {
                const hours = Math.floor(remainingTime / (1000 * 60 * 60));
                const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                const timerElement = document.getElementById(`timer-${estacionId}`);
                timerElement.innerHTML =
                    (hours < 10 ? "0" + hours : hours) + "h " +
                    (minutes < 10 ? "0" + minutes : minutes) + "m " +
                    (seconds < 10 ? "0" + seconds : seconds) + "s";
            }
        }

        // Iniciar cronómetro normal (ascendente)
        function startNormalTimer(estacionId) {
            // Enviar solicitud AJAX al servidor para iniciar el cronómetro
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo base_url('index.php/welcome/iniciar_tiempo_normal'); ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Iniciar un temporizador que aumenta cada segundo
                        countdownEndTimes[estacionId] = Date.now();  // Guardar el tiempo de inicio
                        countdownIntervals[estacionId] = setInterval(() => updateNormalTimer(estacionId), 1000);
                        alert(response.message); // Mensaje de éxito
                    } else {
                        alert(response.message); // Mensaje de error
                    }
                }
            };
            xhr.send("estacion_id=" + estacionId);
        }

        // Actualizar el cronómetro normal en pantalla (tiempo ascendente)
        function updateNormalTimer(estacionId) {
            const now = Date.now();
            const elapsedTime = now - countdownEndTimes[estacionId]; // Calcular el tiempo transcurrido

            const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
            const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

            const timerElement = document.getElementById(`timer-${estacionId}`);
            timerElement.innerHTML =
                (hours < 10 ? "0" + hours : hours) + "h " +
                (minutes < 10 ? "0" + minutes : minutes) + "m " +
                (seconds < 10 ? "0" + seconds : seconds) + "s";
        }
    </script>
</body>
</html>
