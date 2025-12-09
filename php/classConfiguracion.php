<?php
class Configuracion{
    
    private $servername;
    private $username;
    private $password;
    private $database;
    private $db;
    public function __construct(){
        $this->servername = "localhost";
        $this->username = "DBUSER2025";
        $this->password = "DBPSWD2025";
        $this->database = "UO300627_DB";

        $this->db = new mysqli($this->servername,$this->username,$this->password);
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . $this->database);
        $this->db->select_db($this->database);
    }

    /*
    public function reiniciarBD(){
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $tablas = $this->db->query("SHOW TABLES");
        while($tabla = $tablas->fetch_row()){
            $this->db->query("TRUNCATE TABLE " . $tabla[0]);
        }
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    

    public function borrarBD(){   
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $tablas = $this->db->query("SHOW TABLES");
        while($tabla = $tablas->fetch_row()){
            $this->db->query("DROP TABLE " . $tabla[0]);
        }
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }
        */

    public function reiniciarBD(){
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . $this->database);
        $this->db->select_db($this->database);

        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        $this->db->query("DROP TABLE IF EXISTS observacion_facilitador");
        $this->db->query("DROP TABLE IF EXISTS resultado");
        $this->db->query("DROP TABLE IF EXISTS usuario");

        $crearTablaUsuario = "CREATE TABLE usuario (
            id_usuario INT AUTO_INCREMENT PRIMARY KEY, 
            edad INT NOT NULL CHECK (edad >= 0), 
            profesion VARCHAR(40) NOT NULL,
            genero VARCHAR(40) NOT NULL,
            pericia VARCHAR(40) NOT NULL  
        )";
        $this->db->query($crearTablaUsuario);

        $crearTablaResultado = "CREATE TABLE resultado (
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
        )";
        $this->db->query($crearTablaResultado);

        $crearTablaObservacionFacilitador = "CREATE TABLE observacion_facilitador (
            id_observacion INT AUTO_INCREMENT PRIMARY KEY, 
            id_usuario INT NOT NULL,
            comentarios_facilitador TEXT NOT NULL,
            FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
        )";
        $this->db->query($crearTablaObservacionFacilitador);

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    public function borrarBD(){
        $this->db->query("DROP DATABASE IF EXISTS " . $this->database);
    }

    public function exportarBD(){
        $tablas = $this->db->query("SHOW TABLES");

        while ($fila = $tablas->fetch_row()) {
            $nombreTabla = $fila[0];
            
            $archivoCSV = $nombreTabla . ".csv";
            $fp = fopen($archivoCSV, 'w');

            $resultado = $this->db->query("SELECT * FROM " . $nombreTabla);
                
            if ($resultado && $resultado->num_rows > 0) {
                $columnas = [];
                $campos = $resultado->fetch_fields();
                foreach ($campos as $campo) {
                    $columnas[] = $campo->name;
                }
                fputcsv($fp, $columnas, ";");
                while ($datos = $resultado->fetch_assoc()) {
                    fputcsv($fp, $datos, ";");
                }
            }               
            fclose($fp);
        }
    }

    public function guardarUsuario($edad, $profesion, $genero, $pericia){
        $consultaInsertarUsuario = $this->db->prepare("INSERT INTO usuario (edad, profesion, genero, pericia) VALUES (?, ?, ?, ?)");
        $consultaInsertarUsuario->bind_param("isss", $edad, $profesion, $genero, $pericia);
        $consultaInsertarUsuario->execute();
        $id_usuario = $this->db->insert_id;
        return $id_usuario;
    }

    public function guardarResultados($id_usuario, $dispositivo, $valoracion, $propuestas, $comentarios, $tiempo,$completado) {  
        $consultaInsertarResultados = $this->db->prepare("INSERT INTO resultado (id_usuario, dispositivo, tiempo_empleado, completado, comentarios_usuario, propuestas_mejora, valoracion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $consultaInsertarResultados->bind_param("isdisii", $id_usuario, $dispositivo, $tiempo, $completado, $comentarios, $propuestas, $valoracion);
        $consultaInsertarResultados->execute();
        $consultaInsertarResultados->close();
    }

    public function guardarObservacionesFacilitador($id_usuario,$observaciones){
        $consultaInsertarObservaciones = $this->db->prepare("INSERT INTO observacion_facilitador (id_usuario, comentarios_facilitador) VALUES (?, ?)");
        $consultaInsertarObservaciones->bind_param("is", $id_usuario, $observaciones);
        $consultaInsertarObservaciones->execute();
        $consultaInsertarObservaciones->close();
    }
}
?>