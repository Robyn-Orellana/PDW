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
<bpdy>
<form method="post" action="<?php echo base_url('index.php/welcome/guardar'); ?>">
  <div class="form-group">
    <label for="numero_estacion">Número de la Estación</label>
    <input type="number" class="form-control" id="numero_estacion" name="numero_estacion" required>
  </div>
  <div class="form-group">
    <label for="nombre_cliente">Nombre del Cliente</label>
    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
  </div>
  <div class="form-group">
    <label for="tiempo_solicitado">Tiempo Solicitado (en minutos)</label>
    <input type="number" class="form-control" id="tiempo_solicitado" name="tiempo_solicitado">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="tiempo_libre" name="tiempo_libre" value="1">
    <label class="form-check-label" for="tiempo_libre">¿Tiempo Libre (Cronómetro)?</label>
  </div>
 <!--<div class="form-group">
    <label for="fecha">Fecha</label>
    <input type="date" class="form-control" id="fecha" name="fecha" required>
  </div>
-->
  <button type="submit" class="btn btn-primary">Guardar Estación</button>
</form>

</body>
</html>



