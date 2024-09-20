<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/CSS/style.css'); ?>">
</head>
<body>
    <!-- Contenedor principal para centrar el contenido -->
    <div class="container">
        <!-- Botón para regresar al controlador Welcome -->
        <a href="<?php echo site_url('welcome'); ?>" class="btn btn-primary">Regresar a la página principal</a>
        
        <!-- Título centrado -->
        <h2>Crear Nuevo Usuario</h2>

        <?php if ($this->session->flashdata('success')): ?>
            <p><?php echo $this->session->flashdata('success'); ?></p>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <p><?php echo $this->session->flashdata('error'); ?></p>
        <?php endif; ?>

        <!-- Formulario -->
        <?php echo validation_errors(); ?>
        <?php echo form_open('usuarios/guardar'); ?>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo set_value('nombre'); ?>" required>
            <br>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" value="<?php echo set_value('apellido'); ?>" required>
            <br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required>
            <br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            <br>

            <label for="rol">Rol:</label>
            <select name="rol" id="rol" required>
                <option value="operador" <?php echo set_select('rol', 'operador'); ?>>Operador</option>
                <option value="administrador" <?php echo set_select('rol', 'administrador'); ?>>Administrador</option>
            </select>
            <br>

            <input type="submit" value="Crear Usuario">
        </form>
    </div>
</body>
</html>
