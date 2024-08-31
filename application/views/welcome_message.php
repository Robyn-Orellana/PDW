<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: flex-start; 
    height: 100vh;
    margin: 0;
    overflow: hidden; 

.container {
    background-color: #fff;
    padding: 30px; 
    border-radius: 40px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 90%; 
    max-width: 1300px;
    max-height: 80vh; 
    overflow-y: auto; 

h1 {
    margin-bottom: 20px;    
}

.stations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
    gap: 40px; 
    padding: 20px; 
}

.station {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 10px;
    background-color: transparent; 
    box-sizing: border-box;
    height: auto; 
    min-height: 150px; 
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 1em;
    color: #333; 
    font-weight: bold;
}

.station input[type="text"] {
    width: 100%;
    padding: 5px;
    margin-bottom: 10px;
    font-size: 1em;
}

.station button {
    margin-top: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 0.9em; 
}


.timer {
    font-size: 1em; 
    margin-bottom: 10px;
}

.controls {
    margin-bottom: 10px;
}

.controls label {
    display: block;
    margin-bottom: 5px;
}

.controls input, .controls button {
    padding: 5px;
    width: 100%;
    margin-bottom: 5px;
}

.cost-display {
    font-size: 0.9em; 
    margin-top: 10px;
    color: #555;
}

#add-station-btn, #stop-all-btn {
    padding: 10px;
    margin: 10px 5px;
    width: calc(50% - 10px);
    cursor: pointer;
}

	</style>
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
    <script src="script.js"></script>

</body>


</html>
