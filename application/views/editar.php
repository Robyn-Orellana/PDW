<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('editar/CSS/editar.css'); ?>">
</head>
<body>
    <h1>Editar Usuario</h1>

    <?php if (validation_errors()): ?>
        <div style="color:red;">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('usuarios/actualizar/' . $usuario['idUsuario']) ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?= set_value('nombre', $usuario['nombre']) ?>"><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?= set_value('apellido', $usuario['apellido']) ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?= set_value('email', $usuario['email']) ?>"><br>

        <label for="password">Contraseña (solo si desea cambiarla):</label>
        <input type="password" name="password"><br>

        <label for="rol">Rol:</label>
        <input type="text" name="rol" value="<?= set_value('rol', $usuario['rol']) ?>"><br>

        <input type="submit" value="Guardar Cambios">
    </form>

    <a href="<?= site_url('usuarios') ?>">Volver a la lista</a>
</body>
</html>
