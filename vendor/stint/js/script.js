let stations = [];
const costPerMinute = 0.5; // Costo por minuto

function formatTime(seconds) {
    const hrs = Math.floor(seconds / 3600);
    const mins = Math.floor((seconds % 3600) / 60);
    const secs = seconds % 60;
    return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

function addStation() {
    const stationId = stations.length;
    const station = {
        id: stationId,
        timer: null,
        timeRemaining: 0,
        freeMode: false,
        startTime: 0
    };

    stations.push(station);

    const stationElement = document.createElement('div');
    stationElement.classList.add('station');
    stationElement.id = `station-${stationId}`;
    stationElement.innerHTML = `
        <input type="text" id="name-input-${stationId}" placeholder="Nombre de la estación">
        <div class="timer" id="time-display-${stationId}">00:00:00</div>
        <div class="controls">
            <label for="time-input-${stationId}">Tiempo (minutos):</label>
            <input type="number" id="time-input-${stationId}" min="0" value="0">
            <button onclick="startTimer(${stationId})">Iniciar Temporizador</button>
            <button onclick="startFreeTime(${stationId})">Tiempo Libre</button>
            <button onclick="stopTimer(${stationId})">Detener</button>
            <button onclick="resetStation(${stationId})">Reiniciar</button>
        </div>
        <div id="cost-display-${stationId}" class="cost-display"></div>
        <button onclick="removeStation(${stationId})">Eliminar Estación</button>
    `;
    document.getElementById('stations-container').appendChild(stationElement);
}

function startTimer(stationId) {
    const station = stations[stationId];
    const minutes = parseInt(document.getElementById(`time-input-${stationId}`).value);
    if (isNaN(minutes) || minutes <= 0) {
        alert("Por favor, ingresa un tiempo válido en minutos.");
        return;
    }
    
    station.timeRemaining = minutes * 60;
    station.freeMode = false;
    clearInterval(station.timer);
    station.timer = setInterval(() => updateTimer(stationId), 1000);
}

function startFreeTime(stationId) {
    const station = stations[stationId];
    station.freeMode = true;
    station.timeRemaining = 0;
    station.startTime = Date.now();
    clearInterval(station.timer);
    station.timer = setInterval(() => updateFreeTime(stationId), 1000);
}

function updateTimer(stationId) {
    const station = stations[stationId];
    if (station.timeRemaining > 0) {
        station.timeRemaining--;
        document.getElementById(`time-display-${stationId}`).textContent = formatTime(station.timeRemaining);
    } else {
        clearInterval(station.timer);
        document.getElementById(`cost-display-${stationId}`).textContent = "El tiempo ha terminado.";
        alert(`El tiempo ha terminado para la estación ${stationId + 1}.`);
    }
}

function updateFreeTime(stationId) {
    const station = stations[stationId];
    station.timeRemaining = Math.floor((Date.now() - station.startTime) / 1000);
    document.getElementById(`time-display-${stationId}`).textContent = formatTime(station.timeRemaining);
}

function stopTimer(stationId) {
    const station = stations[stationId];
    clearInterval(station.timer);
    if (station.freeMode) {
        const totalMinutes = Math.ceil(station.timeRemaining / 60);
        const totalCost = totalMinutes * costPerMinute;
        document.getElementById(`cost-display-${stationId}`).textContent = `Tiempo usado: ${totalMinutes} minutos. Costo: $${totalCost.toFixed(2)}`;
    }
    station.freeMode = false;
}

function resetStation(stationId) {
    const station = stations[stationId];
    clearInterval(station.timer);
    station.timeRemaining = 0;
    station.freeMode = false;
    document.getElementById(`time-display-${stationId}`).textContent = formatTime(station.timeRemaining);
    document.getElementById(`cost-display-${stationId}`).textContent = "";
    document.getElementById(`time-input-${stationId}`).value = 0;
}

function removeStation(stationId) {
    // Elimina el elemento de la interfaz
    const stationElement = document.getElementById(`station-${stationId}`);
    if (stationElement) {
        stationElement.remove();
    }
    // Elimina la estación del array
    stations = stations.filter(station => station.id !== stationId);
    // Actualiza los IDs de las estaciones restantes
    stations.forEach((station, index) => {
        station.id = index;
        document.getElementById(`station-${station.id}`).id = `station-${station.id}`;
        document.getElementById(`time-display-${station.id}`).id = `time-display-${station.id}`;
        document.getElementById(`cost-display-${station.id}`).id = `cost-display-${station.id}`;
        document.getElementById(`name-input-${station.id}`).id = `name-input-${station.id}`;
        document.getElementById(`time-input-${station.id}`).id = `time-input-${station.id}`;
    });
}

function stopAllTimers() {
    stations.forEach((station, index) => {
        clearInterval(station.timer);
        if (station.freeMode) {
            const totalMinutes = Math.ceil(station.timeRemaining / 60);
            const totalCost = totalMinutes * costPerMinute;
            document.getElementById(`cost-display-${index}`).textContent = `Tiempo usado: ${totalMinutes} minutos. Costo: $${totalCost.toFixed(2)}`;
        }
        station.freeMode = false;
    });
}

function resetAllTimers() {
    stations.forEach((station, index) => {
        resetStation(index);
    });
}
