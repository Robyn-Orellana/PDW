<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Monitoreo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('vendor/css/styles.css?v=1.0'); ?>">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <!-- Botón para agregar una nueva estación -->
        <a href="<?php echo base_url('index.php/welcome/agregar'); ?>" class="btn btn-success mb-3">Agregar Estación</a>
        
        <!-- Contenedor para las tarjetas de estaciones -->
        <div class="row" id="estaciones-container">
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
            
                                <div class="btn-group mt-2">
                                <button onclick="setAndStartTime(<?php echo $estacion['id']; ?>, 15)" class="btn btn-info">+15 minutos</button>
                                <button onclick="setAndStartTime(<?php echo $estacion['id']; ?>, 30)" class="btn btn-info">+30 minutos</button>
                                <button onclick="setAndStartTime(<?php echo $estacion['id']; ?>, 60)" class="btn btn-info">+60 minutos</button>  
                                </div>



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

        // Cargar el estado de los temporizadores desde localStorage
        function loadTimersFromLocalStorage() {
            const timers = JSON.parse(localStorage.getItem('timers')) || {};
            for (let estacionId in timers) {
                const timerData = timers[estacionId];
                if (timerData.type === 'countdown') {
                    countdownEndTimes[estacionId] = timerData.endTime;
                    countdownIntervals[estacionId] = setInterval(() => updateCountdown(estacionId), 1000);
                } else if (timerData.type === 'normal') {
                    normalTimerEndTimes[estacionId] = timerData.startTime;
                    normalTimerIntervals[estacionId] = setInterval(() => updateNormalTimer(estacionId), 1000);
                }
            }
        }

        // Guardar el estado de los temporizadores en localStorage
        function saveTimersToLocalStorage() {
            const timers = {};
            for (let estacionId in countdownEndTimes) {
                timers[estacionId] = {
                    type: 'countdown',
                    endTime: countdownEndTimes[estacionId]
                };
            }
            for (let estacionId in normalTimerEndTimes) {
                timers[estacionId] = {
                    type: 'normal',
                    startTime: normalTimerEndTimes[estacionId]
                };
            }
            localStorage.setItem('timers', JSON.stringify(timers));
        }

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
                            countdownEndTimes[estacionId] = Date.now() + duracion * 60 * 1000;
                            countdownIntervals[estacionId] = setInterval(() => updateCountdown(estacionId), 1000);
                            saveTimersToLocalStorage(); // Guardar estado
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

        // Iniciar cronómetro normal
        function startNormalTimer(estacionId) {
            // Enviar solicitud AJAX al servidor para iniciar el cronómetro
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo base_url('index.php/welcome/iniciar_tiempo_normal'); ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        normalTimerEndTimes[estacionId] = Date.now();
                        normalTimerIntervals[estacionId] = setInterval(() => updateNormalTimer(estacionId), 1000);
                        saveTimersToLocalStorage(); // Guardar estado
                        alert(response.message); // Mensaje de éxito
                    } else {
                        alert(response.message); // Mensaje de error
                    }
                }
            };
            xhr.send("estacion_id=" + estacionId);
        }

        // Actualizar cuenta regresiva
        // Actualizar cuenta regresiva
function updateCountdown(estacionId) {
    let endTime = countdownEndTimes[estacionId];
    let now = Date.now();
    let timeLeft = endTime - now;

    if (timeLeft <= 0) {
        clearInterval(countdownIntervals[estacionId]);
        document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
        delete countdownEndTimes[estacionId];
        
        // Enviar solicitud AJAX al servidor para guardar la hora de fin
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo base_url('index.php/welcome/detener_tiempo_regresivo'); ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("El tiempo regresivo ha finalizado correctamente.");
                } else {
                    alert(response.message);
                }
            }
        };
        xhr.send("estacion_id=" + estacionId);

        saveTimersToLocalStorage(); // Guardar estado
        return;
    }

    let hours = Math.floor(timeLeft / (1000 * 60 * 60));
    let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    document.getElementById(`timer-${estacionId}`).innerHTML = `${pad(hours)}h ${pad(minutes)}m ${pad(seconds)}s`;
}

        // Actualizar cronómetro normal
        function updateNormalTimer(estacionId) {
            let startTime = normalTimerEndTimes[estacionId];
            let now = Date.now();
            let timeElapsed = now - startTime;

            let hours = Math.floor(timeElapsed / (1000 * 60 * 60));
            let minutes = Math.floor((timeElapsed % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeElapsed % (1000 * 60)) / 1000);

            document.getElementById(`timer-${estacionId}`).innerHTML = `${pad(hours)}h ${pad(minutes)}m ${pad(seconds)}s`;
        }

        // Función para formatear el tiempo
        function pad(number) {
            return number < 10 ? '0' + number : number;
        }

        // Reiniciar y empezar el cronómetro normal
       // Reiniciar y empezar el cronómetro normal
function resetAndStartTimer(estacionId) {
    // Detener cualquier intervalo en curso
    if (countdownIntervals[estacionId]) {
        clearInterval(countdownIntervals[estacionId]);
        delete countdownIntervals[estacionId];
        delete countdownEndTimes[estacionId];
    }
    if (normalTimerIntervals[estacionId]) {
        clearInterval(normalTimerIntervals[estacionId]);
        delete normalTimerIntervals[estacionId];
        delete normalTimerEndTimes[estacionId];
    }

    // Enviar solicitud AJAX al servidor para reiniciar el tiempo
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "<?php echo base_url('index.php/welcome/reiniciar_tiempo'); ?>", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
                document.getElementById(`duracion-${estacionId}`).value = ''; // Limpiar input de duración
                saveTimersToLocalStorage(); // Guardar estado
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


//detener tiempo
function stopTimer(estacionId) {
    let stopped = false;

    // Detener cuenta regresiva si está en curso
    if (countdownIntervals[estacionId]) {
        clearInterval(countdownIntervals[estacionId]);
        delete countdownIntervals[estacionId];
        delete countdownEndTimes[estacionId];
        document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
        stopped = true;

        // Enviar solicitud AJAX al servidor para detener el tiempo regresivo
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo base_url('index.php/welcome/detener_tiempo_regresivo'); ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("El tiempo regresivo se ha detenido correctamente."); // Aviso de éxito
                } else {
                    alert(response.message); // Mensaje de error
                }
            }
        };
        xhr.send("estacion_id=" + estacionId);
    }

    // Detener cronómetro normal si está en curso
    if (normalTimerIntervals[estacionId]) {
        clearInterval(normalTimerIntervals[estacionId]);
        delete normalTimerIntervals[estacionId];
        delete normalTimerEndTimes[estacionId];
        document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
        stopped = true;

        // Enviar solicitud AJAX al servidor para detener el cronómetro normal
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo base_url('index.php/welcome/detener_tiempo_normal'); ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("El cronómetro normal se ha detenido correctamente."); // Aviso de éxito
                } else {
                    alert(response.message); // Mensaje de error
                }
            }
        };
        xhr.send("estacion_id=" + estacionId);
    }

    // Solo guardar el estado si se ha detenido al menos un temporizador
    if (stopped) {
        saveTimersToLocalStorage(); // Guardar estado en localStorage
    }
}

// Función para establecer el tiempo y iniciar el cronómetro
function setAndStartTime(estacionId, minutos) {
    // Convertir minutos a segundos
    let segundos = minutos ;

    // Establecer la duración en el input correspondiente
    document.getElementById(`duracion-${estacionId}`).value = segundos;

    // Iniciar la cuenta regresiva con la duración especificada
    startCountdown(estacionId);
}



        // Inicializar temporizadores al cargar la página
        window.onload = function() {
            loadTimersFromLocalStorage(); 
        };
    </script>
</body>
</html>