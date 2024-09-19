CREATE DATABASE cafeinternet;
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
    duración INT DEFAULT NULL,
    FOREIGN KEY (id_estacion) REFERENCES estaciones(id) -- Relación con la tabla 'estaciones'   	
);

