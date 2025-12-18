CREATE DATABASE IF NOT EXISTS UO300627_DB;
USE UO300627_DB;

CREATE TABLE genero (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL
);

INSERT INTO genero (nombre) VALUES ('Masculino'), ('Femenino'), ('Otro');

CREATE TABLE dispositivo (
    id_dispositivo INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL
);

INSERT INTO dispositivo (nombre) VALUES ('Ordenador'), ('Tableta'), ('Telefono');

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY, 
    edad INT NOT NULL CHECK (edad BETWEEN 0 AND 120), 
    profesion VARCHAR(40) NOT NULL,
    id_genero INT NOT NULL,
    pericia INT NOT NULL CHECK (pericia BETWEEN 0 AND 10),
    FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

CREATE TABLE resultado (
    id_resultado INT AUTO_INCREMENT PRIMARY KEY, 
    id_usuario INT NOT NULL,
    id_dispositivo INT NOT NULL, 
    tiempo_empleado DECIMAL(10,2),
    completado BOOLEAN NOT NULL, 
    comentarios_usuario TEXT,
    propuestas_mejora TEXT,
    valoracion INT CHECK(valoracion BETWEEN 0 AND 10),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_dispositivo) REFERENCES dispositivo(id_dispositivo)
);

CREATE TABLE observacion_facilitador (
    id_observacion INT AUTO_INCREMENT PRIMARY KEY, 
    id_usuario INT NOT NULL,
    comentarios_facilitador TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE respuesta (
    id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
    id_resultado INT NOT NULL,
    numero_pregunta INT NOT NULL CHECK (numero_pregunta BETWEEN 1 AND 10),
    valor_respuesta TEXT,
    FOREIGN KEY (id_resultado) REFERENCES resultado(id_resultado),
    UNIQUE KEY respuesta_unica (id_resultado, numero_pregunta)
);