<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Notificaciones</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('vendor/css/style2.css?v=1.0'); ?>">
   
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
        <a href="<?php echo base_url('index.php/welcome'); ?>" class="btn btn-success">REGRESAR</a>
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4>Lista de Notificaciones</h4>
                    <a href="<?php echo base_url('index.php/welcome/nuevanotificacion'); ?>" class="btn btn-success">NUEVO REGISTRO</a>
                </div>
                <div class="table wide-table ">
                    <!--  Tabla  -->
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">nombre alarma</th>
                                <th scope="col">Estación aplicada</th>
                                <th scope="col">Intervalo de uso</th>
                                <th scope="col">Mostrar</th>
                                <th scope="col">editar</th>
                                <th scope="col">eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap JS y dependencias de JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
