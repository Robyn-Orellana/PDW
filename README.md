```markdown
# Instrucciones para Montar la Aplicación Localmente

## Requisitos del Sistema
1. **Servidor Local**: Necesitarás un entorno de servidor local como XAMPP o WAMP.
2. **PHP**: Asegúrate de tener PHP instalado (versiones compatibles: 7.x o superior).
3. **Base de Datos MySQL**: Es necesaria una base de datos MySQL. Puedes usar phpMyAdmin para gestionarla.
4. **Git**: Para clonar el repositorio, es recomendable tener Git instalado.

## Instalación

### 1. Clonar el Repositorio
Clona este repositorio desde GitHub:
```bash
git clone https://github.com/Robyn-Orellana/PDW.git
```

### 2. Configuración del Servidor
Coloca la carpeta clonada en el directorio de tu servidor local (`htdocs` para XAMPP, `www` para WAMP).

### 3. Configuración de la Base de Datos
1. Crea una nueva base de datos MySQL desde phpMyAdmin o usando la consola MySQL.
2. Importa el archivo de la base de datos proporcionado (`database.sql`) a la nueva base de datos creada.
3. Edita el archivo de configuración del proyecto para conectar la base de datos:
   - Ve al archivo `application/config/database.php`.
   - Cambia las credenciales de acceso a la base de datos:
   ```php
   'username' => 'tu_usuario',
   'password' => 'tu_contraseña',
   'database' => 'nombre_de_la_base_de_datos',
   ```

### 4. Configurar las Variables de Entorno
Asegúrate de que el archivo `.env` o los archivos de configuración contengan los valores correctos para tu entorno local.

### 5. Ejecutar la Aplicación
1. Inicia tu servidor local (XAMPP o WAMP).
2. Abre el navegador y accede a `http://localhost/PDW`.

## Características de Código Abierto
Este proyecto es **de código abierto**, lo que significa que es libre para usar, modificar y distribuir. Cualquiera puede contribuir al desarrollo, mejorar las funcionalidades existentes o adaptar la aplicación según sus necesidades.

### Licencia
Este proyecto está licenciado bajo la [Licencia MIT](LICENSE). Puedes consultar el archivo de licencia para más detalles.

### Acceso al Código Fuente
El código fuente de este proyecto está disponible en [GitHub](https://github.com/Robyn-Orellana/PDW).

# Contribuciones
Las contribuciones son bienvenidas. Si deseas contribuir, sigue estos pasos:

1. Haz un fork del proyecto.
2. Crea una nueva rama:
   ```bash
   git checkout -b feature/nueva-funcionalidad
   ```
3. Haz tus cambios y realiza un commit:
   ```bash
   git commit -m "Descripción del cambio"
   ```
4. Envía tus cambios al repositorio remoto:
   ```bash
   git push origin feature/nueva-funcionalidad
   ```


Este archivo guía al usuario a través de la configuración y puesta en marcha de la aplicación en un servidor local. Además, fomenta la contribución al proyecto siguiendo buenas prácticas de Git.

El manual de usuario y manual tecnico estan en la ruta PDW/Informacion ahí encontraras toda la informacion sobre como utilizar la pagina y su estructura interna para mejoras o cambios que nececites. 
El query para la creacion de la base de datos igualmente se encuentra en PDW/Informacion, el cual solo deberas de ejecutar en tu base de datos para la crecion de la base de datos y las tablas. 

Si Deseas contactar al equipo de creacion del proyecto, puedes enviar un correo a los siquiente emails:
robynorellana16@gmial.com
samuelgeronimo.rosales@gmail.com
ferarroyo0102@gmail.com