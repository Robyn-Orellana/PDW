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
            <div class="d-flex justify-content-between mb-3">
                <a href="<?php echo base_url('index.php/welcome'); ?>" class="btn btn-success">REGRESAR</a>
                <a href="<?php echo base_url('index.php/welcome/nuevanotificacion'); ?>" class="btn btn-success">NUEVO REGISTRO</a>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Lista de Notificaciones</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre Alarma</th>
                                <th scope="col">Estación Aplicada</th>
                                <th scope="col">Intervalo de Uso</th>
                                <th scope="col">Mostrar</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notificaciones as $notificacion): ?>
                            <tr>
                                <td><?php echo $notificacion['id']; ?></td>
                                <td><?php echo $notificacion['nombrenotifi']; ?></td>
                                <td><?php echo $notificacion['estacion_id']; // Aquí deberías buscar el nombre de la estación ?></td>
                                <td><?php echo $notificacion['intervalo']; ?> </td>
                                <td>
            <button class="btn btn-info" onclick="mostrarNotificacion(<?php echo $notificacion['id']; ?>)">Mostrar</button>
        </td>

                                <td>
                                    <a href="<?php echo base_url('index.php/welcome/editarnotificacion/' . $notificacion['id']); ?>" class="btn btn-warning">Editar</a>
                                </td>

                                <td>
    <a href="<?php echo site_url('welcome/eliminarNotificacion/' . $notificacion['id']); ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta notificación?');">Eliminar</a>
</td>



                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mostrarNotificacion(id) {
    $.ajax({
        url: "<?php echo site_url('welcome/obtener_notificacion/'); ?>" + id,
        type: "GET",
        success: function(data) {
            let notificacion = JSON.parse(data);
            Swal.fire({
                title: notificacion.titulo,
                text: notificacion.mensaje,
                background: notificacion.colorFondo,
                confirmButtonColor: notificacion.colorBoton,
                icon: notificacion.imageUrl ? 'info' : undefined, // Muestra el icono si no hay imagen
                imageUrl: notificacion.imageUrl || '', // Usa la URL de la imagen si existe
                imageWidth: notificacion.imageWidth || 150, // Valor por defecto
                imageHeight: notificacion.imageHeight || 150 // Valor por defecto
            });
        },
        error: function() {
            Swal.fire("Error", "No se pudo obtener la notificación.", "error");
        }
    });
}

</script>


<!-- Incluir Bootstrap JS y dependencias de JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
function confirmarEliminacion(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta notificación?')) {
        // Realizar la solicitud AJAX para eliminar la notificación
        $.ajax({
            url: "<?php echo site_url('welcome/eliminarNotificacion/'); ?>" + id,
            type: "POST",
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('La notificación ha sido eliminada.');
                    location.reload(); // Recargar la página para reflejar cambios
                } else {
                    alert('Hubo un problema al eliminar la notificación.');
                }
            },
            error: function() {
                alert('Hubo un problema al eliminar la notificación.');
            }
        });
    }
}
</script>




</body>
</html>
