README

Descripción del Proyecto
Este sistema gestiona el tiempo de uso de varias estaciones, como en un café internet o espacios compartidos, mediante cronómetros independientes. Cada estación cuenta con un cronómetro configurable para cada usuario, permitiendo un control preciso del tiempo. El sistema está diseñado para ser eficiente y fácil de usar, con una interfaz clara para gestionar múltiples estaciones simultáneamente.

Funcionalidades Principales
Soporte para múltiples estaciones: Gestión de varios cronómetros, cada uno vinculado a una estación específica.

Interfaz gráfica atractiva: Diseño moderno que organiza los cronómetros en módulos fáciles de manejar.

Registo de Usuario: se podrá registrar el nombre del usuario que desea utilizar una estación.

Selección de tiempo personalizada: Los usuarios pueden elegir el tiempo que desean usar en cada estación.

Control independiente de cronómetros: Cada cronómetro funciona de manera autónoma.

Controles básicos: Agregar estación, Iniciar tiempo definido, Iniciar tiempo normal,  Opción de iniciar,
y detener.

Tecnologías Utilizadas
Frontend: HTML, CSS, JavaScript
Base de Datos: MySQL

Frameworks/Librerías:
CodeIgniter (PHP para backend)

Entorno de Desarrollo: Visual Studio Code

Requisitos del Sistema
Node.js v20.17.0 
npm v10.8.3 
MySQL
XAMPP

Instalación y Configuración 

git clone https://github.com/Robyn-Orellana/PDW.git

crea la base de datos:  cafeinternet
CREATE TABLE estaciones (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único de cada equipo
    numero_estacion INT NOT NULL, -- Número de la estación
    nombre_estacion VARCHAR(255) NOT NULL, -- Nombre de la estación o equipo  
    activa BOOLEAN DEFAULT TRUE -- Indica si la estación está activa
);


CREATE TABLE tiempos_estaciones (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único para cada registro de tiempo
    id_estacion INT NOT NULL, -- Relaciona con la tabla 'estaciones'
    hora_inicio DATETIME NOT NULL, -- Tiempo de inicio
    hora_fin DATETIME, -- Tiempo de fin (NULL si sigue activa)

    FOREIGN KEY (id_estacion) REFERENCES estaciones(id) -- Relación con la tabla 'estaciones'
    	
);

ALTER TABLE tiempos_estaciones ADD COLUMN duracion INT DEFAULT NULL;



Instrucciones de Uso:

 Agregar estación: Al presionar este botón, se  podrá ingresar el nombre del cliente y el número de estación que desea utilizar. Esto crea una nueva estación con un cronómetro asignado, permitiendo que cada cliente tenga un control individualizado de su tiempo.

Iniciar tiempo definido: Esta opción permite  establecer un tiempo específico en segundos para el cronómetro. Si el usuario no ingresa un tiempo antes de iniciar, el sistema enviará una alerta para recordarle que debe definir un tiempo antes de continuar. Es ideal para cuando se requiere un control preciso del tiempo de uso.

Iniciar tiempo normal: En esta opción, el cronómetro comenzará a correr automáticamente sin necesidad de que el usuario ingrese un tiempo específico. Es útil cuando se quiere simplemente medir el tiempo transcurrido sin definir un límite.

Iniciar: Permite comenzar el cronómetro desde el tiempo definido o desde cero, según la configuración seleccionada.

Detener: Detiene el cronómetro en cualquier momento, pausando el conteo. El tiempo se detendrá y quedará guardado en la estación y en la base de datos, permitiendo que se reanude o reinicie más tarde si es necesario.