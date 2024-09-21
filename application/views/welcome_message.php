<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estaciones de Monitoreo</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="<?php echo base_url('vendor/css/styles.css?v=1.0'); ?>">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Archivo JavaScript de manejo de cronómetros -->
    <script src="<?php echo base_url('vendor/script/timers.js?v=1.0'); ?>"></script>
</head>

<body>

    <div class="container mt-3">
        <a href="<?php echo base_url('index.php/welcome/agregar'); ?>" class="btn btn-success mb-3">Agregar Estación</a>
        <a href="<?php echo base_url('index.php/welcome/notificacion'); ?>" class="btn btn-success mb-3">Notificaciones Personalizadas</a>
    </div>

    <div class="container mt-5">
        <!-- Contenedor para las tarjetas de estaciones -->
        <div class="row" id="estaciones-container">
            <?php if (!empty($estaciones)): ?>
                <?php foreach ($estaciones as $estacion): ?>
                    <div id="card-estacion-<?php echo $estacion['numero_estacion']; ?>" class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Estación Nº <?php echo $estacion['numero_estacion']; ?></span>

                                <!-- Botón para eliminar la estación con imagen -->
                                <button onclick="confirmarEliminacion(<?php echo $estacion['id']; ?>)" class="btn btn-danger">
                                    <img src="<?php echo base_url('vendor/imgs/elim.png'); ?>" alt="Eliminar">
                                </button>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Nombre de la Estación: <?php echo $estacion['nombre_estacion']; ?></h5>
                                <p class="timer" id="timer-<?php echo $estacion['id']; ?>">00h 00m 00s</p>

                                <!-- Input para ingresar la duración de la cuenta regresiva -->
                                <input type="number" id="duracion-<?php echo $estacion['id']; ?>" placeholder="Duración en minutos" class="form-control mb-2">

                                <!-- Botones para añadir tiempo predefinido -->
                                <div class="btn-group mt-2" role="group">
                                    <button onclick="setAndStartTime(<?php echo $estacion['id']; ?>, 15)" class="btn btn-info">+15 minutos</button>
                                    <button onclick="setAndStartTime(<?php echo $estacion['id']; ?>, 30)" class="btn btn-info">+30 minutos</button>
                                    <button onclick="setAndStartTime(<?php echo $estacion['id']; ?>, 60)" class="btn btn-info">+60 minutos</button>  
                                </div>

                                <!-- Botones para controlar el tiempo -->
                                <div class="btn-group mt-3" role="group">
                                    <button onclick="startCountdown(<?php echo $estacion['id']; ?>)" class="btn btn-primary">Iniciar Tiempo Definido</button>
                                    <button onclick="startNormalTimer(<?php echo $estacion['id']; ?>)" class="btn btn-success">Iniciar Tiempo Normal</button>
                                </div>
                                <div class="btn-group mt-2" role="group">
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

    <!-- Script para pasar las notificaciones a JavaScript -->
    <script>
        // Crear un objeto donde la clave es el ID de la estación y el valor es el array de notificaciones
        let notificationsByStation = <?php 
            $notificacionesJs = [];
            foreach ($estaciones as $estacion) {
                $notificacionesJs[$estacion['id']] = $estacion['notificaciones'];
            }
            echo json_encode($notificacionesJs); 
        ?>;
    </script>


    <script>
        let countdownIntervals = {}; // Para cronómetros regresivos
        let normalTimerIntervals = {}; // Para cronómetros normales
        let countdownEndTimes = {};  // Para hora de finalización de cronómetros regresivos
        let normalTimerEndTimes = {}; // Para hora de inicio de cronómetros normales
        let countdownInitialDurations = {}; // Para almacenar la duración inicial de cuenta regresiva

        let triggeredNotifications = {}; // { stationId: Set de notificationIds }

        // Inicializar triggeredNotifications
        for (let estacionId in notificationsByStation) {
            triggeredNotifications[estacionId] = new Set();
        }

        // Cargar el estado de los temporizadores desde localStorage
        function loadTimersFromLocalStorage() {
            const timers = JSON.parse(localStorage.getItem('timers')) || {};
            for (let estacionId in timers) {
                const timerData = timers[estacionId];
                if (timerData.type === 'countdown') {
                    countdownEndTimes[estacionId] = timerData.endTime;
                    countdownInitialDurations[estacionId] = timerData.initialDuration;
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
                    endTime: countdownEndTimes[estacionId],
                    initialDuration: countdownInitialDurations[estacionId] || null
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
            let duracion = parseInt(document.getElementById(`duracion-${estacionId}`).value, 10); // Duración en minutos

            if (duracion > 0) {
                // Enviar solicitud AJAX al servidor para iniciar el tiempo
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo base_url('index.php/welcome/iniciar_tiempo_regresivo'); ?>", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Convertir duracion a milisegundos
                            let duracionMs = duracion * 60 * 1000;
                            countdownEndTimes[estacionId] = Date.now() + duracionMs;
                            countdownInitialDurations[estacionId] = duracion;
                            countdownIntervals[estacionId] = setInterval(() => updateCountdown(estacionId), 1000);
                            saveTimersToLocalStorage(); // Guardar estado
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#d33'
                            });
                        }
                    }
                };
                xhr.send("estacion_id=" + estacionId + "&duracion=" + duracion);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'AVISO!',
                    text: 'Define el tiempo',
                    confirmButtonColor: '#007bff'
                });
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
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            confirmButtonColor: '#3085d6'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            };
            xhr.send("estacion_id=" + estacionId);
        }

        // Actualizar cuenta regresiva
        function updateCountdown(estacionId) {
            let endTime = countdownEndTimes[estacionId];
            let now = Date.now();
            let timeLeft = endTime - now;

            if (timeLeft <= 0) {
                clearInterval(countdownIntervals[estacionId]);
                document.getElementById(`timer-${estacionId}`).innerHTML = "00h 00m 00s";
                delete countdownEndTimes[estacionId];
                delete countdownInitialDurations[estacionId];

                // Enviar solicitud AJAX al servidor para guardar la hora de fin
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo base_url('index.php/welcome/detener_tiempo_regresivo'); ?>", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Finalizado!',
                                text: "El tiempo regresivo ha finalizado correctamente.",
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#d33'
                            });
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

            // Calcular tiempo transcurrido en minutos
            let initialDuration = countdownInitialDurations[estacionId];
            let timeElapsedMinutes = Math.floor(initialDuration - (timeLeft / 60000));

            // Verificar y activar notificaciones
            checkNotifications(estacionId, 'countdown', timeElapsedMinutes);
        }

        // Actualizar cronómetro normal
        function updateNormalTimer(estacionId) {
            let startTime = normalTimerEndTimes[estacionId];
            let now = Date.now();
            let timeElapsed = now - startTime;

            console.log(`Tiempo transcurrido (ms) para la estación ${estacionId}: ${timeElapsed}`);

            let hours = Math.floor(timeElapsed / (1000 * 60 * 60));
            let minutes = Math.floor((timeElapsed % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeElapsed % (1000 * 60)) / 1000);

            document.getElementById(`timer-${estacionId}`).innerHTML = `${pad(hours)}h ${pad(minutes)}m ${pad(seconds)}s`;

            // Calcular tiempo transcurrido en minutos
            let timeElapsedMinutes = Math.floor(timeElapsed / 60000);

            // Verificar y activar notificaciones
            checkNotifications(estacionId, 'normal', timeElapsedMinutes);
        }

        // Función para formatear el tiempo
        function pad(number) {
            return number < 10 ? '0' + number : number;
        }

        // Reiniciar y empezar el cronómetro normal
        function resetAndStartTimer(estacionId) {
            // Detener cualquier intervalo en curso
            if (countdownIntervals[estacionId]) {
                clearInterval(countdownIntervals[estacionId]);
                delete countdownIntervals[estacionId];
                delete countdownEndTimes[estacionId];
                delete countdownInitialDurations[estacionId];
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
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            confirmButtonColor: '#3085d6'
                        });

                        // Iniciar automáticamente después de reiniciar
                        startNormalTimer(estacionId); // Inicia el cronómetro de tiempo libre
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            };
            xhr.send("estacion_id=" + estacionId);
        }

        // Detener tiempo
        function stopTimer(estacionId) {
            let stopped = false;

            // Detener cuenta regresiva si está en curso
            if (countdownIntervals[estacionId]) {
                clearInterval(countdownIntervals[estacionId]);
                delete countdownIntervals[estacionId];
                delete countdownEndTimes[estacionId];
                delete countdownInitialDurations[estacionId];
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
                            Swal.fire({
                                icon: 'success',
                                title: '¡Detenido!',
                                text: "El tiempo regresivo se ha detenido correctamente.",
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#d33'
                            });
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
                            Swal.fire({
                                icon: 'success',
                                title: '¡Detenido!',
                                text: "El cronómetro normal se ha detenido correctamente.",
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#d33'
                            });
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
            // Establecer la duración en el input correspondiente
            document.getElementById(`duracion-${estacionId}`).value = minutos;

            // Iniciar la cuenta regresiva con la duración especificada
            startCountdown(estacionId);
        }

        // Función para verificar y desencadenar notificaciones
        function checkNotifications(estacionId, timerType, timeElapsedMinutes) {
            let stationNotifications = notificationsByStation[estacionId];
            if (!stationNotifications) return;

            stationNotifications.forEach(notif => {
                let intervalo = parseInt(notif.intervalo, 10); // en minutos
                let notifId = notif.id;

                if (!triggeredNotifications[estacionId].has(notifId)) {
                    if (timeElapsedMinutes >= intervalo) {
                        triggerNotification(notif);
                        triggeredNotifications[estacionId].add(notifId);
                    }
                }
            });
        }
// Función para mostrar la notificación usando SweetAlert
function triggerNotification(notif) {
    let options = {
        title: notif.titulo,
        text: notif.mensaje,
        background: notif.colorFondo,
        confirmButtonColor: notif.colorBoton
    };

    // Verifica si imageUrl es una URL o el nombre de un icono
    if (notif.imageUrl && (notif.imageUrl.startsWith('http://') || notif.imageUrl.startsWith('https://'))) {
        // Es una URL de imagen
        options.imageUrl = notif.imageUrl;
        options.imageWidth = notif.imageWidth;
        options.imageHeight = notif.imageHeight;
    } else if (notif.icono) {
        // Es un ícono (usa el campo 'icono' de la BD para el nombre del icono)
        options.icon = notif.icono;
    }

    Swal.fire(options);
}


        // Inicializar temporizadores al cargar la página
        window.onload = function() {
            loadTimersFromLocalStorage(); 
        };
    </script>

</body>
</html>
