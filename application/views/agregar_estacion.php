<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Nueva Estación</h2>
        <!-- Formulario para agregar una nueva estación -->
        <form method="post" action="<?php echo base_url('index.php/welcome/guardar_estacion'); ?>">
            <div class="form-group">
                <label for="numeroEstacion">Número de Estación</label>
                <input type="number" class="form-control" id="numeroEstacion" name="numero_estacion" required>
            </div>
            <div class="form-group">
                <label for="nombreEstacion">Nombre de Estación</label>
                <input type="text" class="form-control" id="nombreEstacion" name="nombre_estacion" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Estación</button>
        </form>
    </div>
</body>
</html>




