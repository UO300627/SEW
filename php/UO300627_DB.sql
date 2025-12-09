CREATE DATABASE IF NOT EXISTS UO300627_DB;
USE UO300627_DB;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY, 
    edad INT NOT NULL CHECK (edad >= 0),	
	profesion VARCHAR(40) NOT NULL,
    genero VARCHAR(40) NOT NULL,
    pericia VARCHAR(40) NOT NULL  
);

CREATE TABLE resultado (
    id_resultado INT AUTO_INCREMENT PRIMARY KEY, 
    id_usuario INT NOT NULL,
    dispositivo varchar(20),
    tiempo_empleado DECIMAL(10,2),
    completado BOOLEAN NOT NULL, 
    comentarios_usuario TEXT,
    propuestas_mejora TEXT,
    valoracion INT CHECK (valoracion BETWEEN 0 AND 10), 
    CHECK (dispositivo IN ('ordenador', 'tableta', 'telefono')),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE observacion_facilitador (
    id_observacion INT AUTO_INCREMENT PRIMARY KEY, 
    id_usuario INT NOT NULL,
    comentarios_facilitador TEXT NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);