<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporizador de Café Internet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>
<style>
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
   }
}
</style>
<body>  
<div class="container">
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Estacion de Monitoreo</h5>
    <p class="card-text">Administra las estaciones de monitoreo</p>
    <a href="<?php echo base_url('index.php/welcome/agregar'); ?>" class="btn btn-primary">Agregar Nueva Estación</a>
  </div>
</div>
</div>

</body>
</html>