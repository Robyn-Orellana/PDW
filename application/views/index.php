<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/CSS/listar.css'); ?>">
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <a href="<?= site_url('usuarios/agregar') ?>">Agregar Usuario</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['idUsuario'] ?></td>
            <td><?= $usuario['nombre'] ?></td>
            <td><?= $usuario['apellido'] ?></td>
            <td><?= $usuario['email'] ?></td>
            <td><?= $usuario['rol'] ?></td>
            <td>
            <a href="<?= site_url('usuarios/editar/' . $usuario['idUsuario']) ?>">Editar</a>

                <a href="<?= site_url('usuarios/eliminar/' . $usuario['idUsuario']) ?>">Eliminar</a>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>
</body>
</html>
