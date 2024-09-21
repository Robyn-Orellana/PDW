
Página
1
de 3
Proyecto ejemplo: https://www.online-stopwatch.com/spanish/
Lenguaje: Adobe flex
Base de datos: NA
# Timer para Control de Uso de Equipos
## Descripción General
Este proyecto tiene como objetivo desarrollar una aplicación web que funcione como
un
timer para controlar el uso de equipos. La aplicación permitirá a los usuarios
configurar
y utilizar tanto un temporizador que cuente hacia abajo (countdown) como un
cronómetro
que cuente hacia arriba (count-up). La aplicación estará disponible en español y
será
accesible desde cualquier navegador web.
## Funcionalidades Principales
- Debe poder existir un mantenimiento o clasificador donde se puedan crearse,
editarse,
darse de baja diferentes espacios de trabajo o equipos que incluyan el uso de las
funciones
de temporizador o cronometro
- Debe permitirse personalizar esos espacios con una imagen de portada, color,
nombre,
descripcion u otro que considere. Debe tomar en cuenta de tener una configuracion
por default
### Temporizador (Cuenta Regresiva)
- El usuario podrá establecer un tiempo específico para la cuenta regresiva.
- La cuenta regresiva debe iniciarse al presionar un botón de "Inicio" y detenerse
al presionar "Pausa".
- Debe haber una opción para reiniciar la cuenta regresiva.
- Al llegar a cero, el timer debe emitir una notificación visual y/o sonora.
### Cronómetro (Cuenta hacia Arriba)
- El cronómetro debe empezar desde cero y contar hacia arriba al presionar
"Inicio".
- El cronómetro se puede pausar y reiniciar en cualquier momento.
- Debe mostrar el tiempo transcurrido en horas, minutos y segundos.
### Configuración de Intervalos
- Opción para configurar múltiples intervalos de tiempo que pueden repetirse en
ciclos.
- Capacidad para guardar configuraciones de intervalos predefinidos para uso
frecuente.
### Notificaciones
- **Visuales:** Cambio de color en la pantalla cuando se alcanza el tiempo.
- **Sonoras:** Posibilidad de activar/desactivar una alarma o sonido al final del
conteo.
### Interfaz de Usuario
- Diseño sencillo, accesible e intuitivo.
- Compatible con diferentes dispositivos (responsive design).
- Instrucciones claras y visibles para la operación del timer.
## Requisitos Técnicos
### Plataforma
- Aplicación web desarrollada utilizando tecnologías HTML5, CSS3 y JavaScript
con bootrapt 3 o 4 y Codeigniter 3.x
- Posibilidad de almacenamiento en el navegador (localStorage) para guardar
las configuraciones del usuario.
- Guardar trazabilidad e historial de uso en base de datos SQLite, H2 o MySQL |
MariaDB
### Compatibilidad
- Compatible con los navegadores más comunes: Chrome, Firefox, Edge, Safari.
### Accesibilidad (Opcional)
- Consideraciones de accesibilidad para usuarios con discapacidades visuales y
auditivas.
## Requisitos de Desempeño
- El timer debe funcionar en tiempo real sin retrasos perceptibles.
- Tiempo de respuesta bajo al interactuar con la interfaz (iniciar, pausar,
reiniciar).
## Seguridad (No aplica)
- Implementación de mecanismos para proteger los datos del usuario, aunque el nivel
de riesgo es bajo debido a la naturaleza de la aplicación.
## Pruebas
- Pruebas de funcionalidad para garantizar que el timer cuente correctamente.
- Pruebas de compatibilidad en diferentes dispositivos y navegadores.
- Pruebas de usabilidad para asegurar que la interfaz sea intuitiva.
## Documentación
- **Manual de usuario:** Detalla cómo utilizar la aplicación.
- **Documentación técnica:** Facilita el mantenimiento y futuras actualizaciones.
- **README.md** Se debe documentar en un archivo .md como montar la aplicacion de
forma
local o un servidor de modo que cualquier usuario con conocimiento basico en
informatica
sea capaz de montarlo.
*Debe especificar en su .md:
## Características de Código Abierto
Este proyecto es **de código abierto**, lo que significa que es libre para
usar, modificar
y distribuir. Cualquiera puede contribuir al desarrollo, mejorar las
funcionalidades existentes
o adaptar la aplicación según sus necesidades.
### Licencia
Este proyecto está licenciado bajo la [Licencia MIT](LICENSE). Puedes
consultar el
archivo de licencia para más detalles.



### ACCESO AL CÓDIGO MODIFICADO
El código fuente de este proyecto está disponible en
[GitHub](https://github.com/tu-usuario/nombre-del-repositorio).
#Contribuciones





### ACCESO AL CÓDIGO MODIFICADO
El código fuente de este proyecto está disponible en
[GitHub](https://github.com/Robyn-Orellana/PDW.git).
Rama: samuelparcial2

### CONTRIBUCION
hola Soy Samuel Gerónomo 
Carné 0905-21-12151

Agregue una nueva modificación, sobre la creacion personalizada de NOTIFICACIONES

primero: 
En la parte principal del proyecto, se agrego un boton "Noticicaciones Personalizadas".

Al ingresar se muestra un apartado donde podras visualizar las notificaciones que creaste, el Id, nombre de la alarma,
el id de la estación aplicada, el intervalo en el que se mostrara la notificación, TRES botones: editar y eliminar y Nuevo registro.

--BOTON NUEVO REGISTRO:--

Muestra dos botones, REGRESAR Y PREVISUALIZAR: Regresar sirve para volver a la pagina anterior y Previsualizar Notificacion para poder ver como va la edición.

Se mostrara un formulario en el cual debes ingresar las características que deseas en tu notificación.
ESTACION: podras ver una lista de las estaciones que se tienen guardadas, dede ese punto podras asignarla esa notificacion a esa estacion.
Nombre de tu notificación, Título para mostrar, un mensaje adicional, en tipo de alerta podras colocar sea un icono o algun link para cargar una imagen. Al seleccionar imagen, despliega un lugar para poner direnccion URL y modificar el tamaño de la imagen.  
A demas poder modificar los colores, sea del fondo de la notificacion y el boton.

Por ultimo ingrear el intervalo de timepo en minutos en el que quieres que aparezca por estacion.

Boton "Crear Notificacion"

--BOTON DE EDITAR:
Funciona de la misma manera que la del boton de NUEVO REGISTRO, solo cambia un boton al finalizar para actualizar.

--Eliminar
sirve para eliminar la notificación creada.





Las contribuciones son bienvenidas. Si deseas contribuir, por favor sigue
estos pasos:
Haz un fork del proyecto.
Crea una nueva rama (git checkout -b feature/nueva-funcionalidad).
Realiza tus cambios y haz commit (git commit -m 'Añadir nueva
funcionalidad').
Haz push a la rama (git push origin feature/nueva-funcionalidad).
Abre un pull request.
Contacto
Para cualquier consulta o sugerencia, puedes contactarme en tu-
email@ejemplo.com.
**Agrege todo en cuanto usted considere**