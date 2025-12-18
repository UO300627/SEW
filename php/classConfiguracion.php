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

    public function reiniciarBD(){  
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        $this->db->query("DROP TABLE IF EXISTS respuesta");
        $this->db->query("DROP TABLE IF EXISTS observacion_facilitador");
        $this->db->query("DROP TABLE IF EXISTS resultado");
        $this->db->query("DROP TABLE IF EXISTS usuario");
        $this->db->query("DROP TABLE IF EXISTS dispositivo");
        $this->db->query("DROP TABLE IF EXISTS genero");
        

        $crearTablaGenero = "CREATE TABLE genero (
            id_genero INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(40) NOT NULL
        )";
        $this->db->query($crearTablaGenero);

        $this->db->query("INSERT INTO genero (nombre) VALUES ('Masculino'), ('Femenino'), ('Otro')");

    
        $crearTablaDispositivo = "CREATE TABLE dispositivo (
            id_dispositivo INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(40) NOT NULL
        )";
        $this->db->query($crearTablaDispositivo);

        $this->db->query("INSERT INTO dispositivo (nombre) VALUES ('Ordenador'), ('Tableta'), ('Telefono')");

    
        $crearTablaUsuario = "CREATE TABLE usuario (
            id_usuario INT AUTO_INCREMENT PRIMARY KEY, 
            edad INT NOT NULL CHECK (edad BETWEEN 0 AND 120), 
            profesion VARCHAR(40) NOT NULL,
            id_genero INT NOT NULL,
            pericia INT NOT NULL CHECK (pericia BETWEEN 0 AND 10),
            FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
        )";
        $this->db->query($crearTablaUsuario);


        $crearTablaResultado = "CREATE TABLE resultado (
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
        )";
        $this->db->query($crearTablaResultado);

        $crearTablaObservacionFacilitador = "CREATE TABLE observacion_facilitador (
            id_observacion INT AUTO_INCREMENT PRIMARY KEY, 
            id_usuario INT NOT NULL,
            comentarios_facilitador TEXT NOT NULL,
            FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
        )";

        $this->db->query($crearTablaObservacionFacilitador);        


        $crearTablaRespuesta = "CREATE TABLE respuesta (
            id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
            id_resultado INT NOT NULL,
            numero_pregunta INT NOT NULL CHECK (numero_pregunta BETWEEN 1 AND 10),
            valor_respuesta TEXT,
            FOREIGN KEY (id_resultado) REFERENCES resultado(id_resultado),
            UNIQUE KEY respuesta_unica (id_resultado, numero_pregunta)
        )";
        $this->db->query($crearTablaRespuesta);
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    public function borrarBD(){
        $this->db->query("DROP DATABASE IF EXISTS " . $this->database);
    }

    public function exportarBD(){
        $nombreArchivo = "datos_exportados.csv";
        $archivoExportado = fopen($nombreArchivo, 'w');

        $encabezados = ['id_usuario', 'edad', 'profesion', 'id_genero', 'genero','pericia', 
            'id_resultado','id_dispositivo', 'dispositivo','tiempo_empleado', 'completado', 'comentarios_usuario', 'propuestas_mejora','valoracion', 
            'r1', 'r2', 'r3', 'r4', 'r5', 'r6', 'r7', 'r8', 'r9', 'r10',
            'id_observacion','comentarios_facilitador'
        ];

        fputcsv($archivoExportado, $encabezados, ";");
        
        $consultaObtenerGenero = $this->db->prepare("SELECT nombre FROM genero WHERE id_genero = ?");   
        $consultaResultado = $this->db->prepare("SELECT * FROM resultado WHERE id_usuario = ?");      
        $consultaObtenerDispositivo = $this->db->prepare("SELECT nombre FROM dispositivo WHERE id_dispositivo = ?");     
        $consultaObservacionesFacilitador = $this->db->prepare("SELECT * FROM observacion_facilitador WHERE id_usuario = ?");
        $consultaObtenerRespuestas = $this->db->prepare("SELECT numero_pregunta, valor_respuesta FROM respuesta WHERE id_resultado = ?");
        $usuarios = $this->db->query("SELECT * FROM usuario");

        while ($usuario = $usuarios->fetch_assoc()) {
            $pruebaUsabilidad = []; 
            $idUsuario = $usuario['id_usuario'];

            $genero = "";
            $consultaObtenerGenero->bind_param("i", $usuario['id_genero']);
            $consultaObtenerGenero->execute();
            $resultadoGenero = $consultaObtenerGenero->get_result();

            if ($datoGenero = $resultadoGenero->fetch_assoc()) {
                $genero = $datoGenero['nombre'];
            }

            $resultado = null; 
            $dispositivo = "";
            $consultaResultado->bind_param("i", $idUsuario);
            $consultaResultado->execute();
            $resultadoFinal = $consultaResultado->get_result();

            $respuestas = [
                1 => "", 2 => "", 3 => "", 4 => "", 5 => "",
                6 => "", 7 => "", 8 => "", 9 => "", 10 => ""
            ];
            if ($datosResultado = $resultadoFinal->fetch_assoc()) {
                $resultado = $datosResultado; 
                
                $consultaObtenerDispositivo->bind_param("i", $datosResultado['id_dispositivo']);
                $consultaObtenerDispositivo->execute();
                $resultadoDispositivo = $consultaObtenerDispositivo->get_result(); 
                if ($datoDispositivo = $resultadoDispositivo->fetch_assoc()) {
                    $dispositivo = $datoDispositivo['nombre'];
                }

                $consultaObtenerRespuestas->bind_param("i", $datosResultado['id_resultado']);
                $consultaObtenerRespuestas->execute();
                $respuestasObtenidas = $consultaObtenerRespuestas->get_result();

                while ($resp = $respuestasObtenidas->fetch_assoc()) {
                    $numero = $resp['numero_pregunta'];
                    $valor = $resp['valor_respuesta']; 

                    if($valor == "111"){
                        $valor = "No respondida";
                        $resultado['completado'] = 0;
                    }elseif ($valor === null) {
                        $valor = "-";
                    }
                    $respuestas[$numero] = $valor;
                }
            }

            $observacionesFacilitador = null;
            $consultaObservacionesFacilitador->bind_param("i", $idUsuario);
            $consultaObservacionesFacilitador->execute();
            $resultadoObservacionesFacilitador = $consultaObservacionesFacilitador->get_result();

            if ($datoObservacionesFacilitador = $resultadoObservacionesFacilitador->fetch_assoc()) {
                $observacionesFacilitador = $datoObservacionesFacilitador;
            }

            $pruebaUsabilidad[] = $usuario['id_usuario'];
            $pruebaUsabilidad[] = $usuario['edad'];
            $pruebaUsabilidad[] = $usuario['profesion'];
            $pruebaUsabilidad[] = $usuario['id_genero'];
            $pruebaUsabilidad[] = $genero; 
            $pruebaUsabilidad[] = $usuario['pericia'];

            if ($resultado) {
                $pruebaUsabilidad[] = $resultado['id_resultado'];
                $pruebaUsabilidad[] = $resultado['id_dispositivo'];
                $pruebaUsabilidad[] = $dispositivo; 
                $pruebaUsabilidad[] = ($resultado['tiempo_empleado'] === null) ? "-" : $resultado['tiempo_empleado'];
                $pruebaUsabilidad[] = $resultado['completado'];
                $pruebaUsabilidad[] = ($resultado['comentarios_usuario'] === null) ? "-" : $resultado['comentarios_usuario'];
                $pruebaUsabilidad[] = ($resultado['propuestas_mejora'] === null) ? "-" : $resultado['propuestas_mejora'];
                $pruebaUsabilidad[] = ($resultado['valoracion'] === null) ? "-" : $resultado['valoracion'];

                $pruebaUsabilidad[] = $respuestas[1];
                $pruebaUsabilidad[] = $respuestas[2];
                $pruebaUsabilidad[] = $respuestas[3];
                $pruebaUsabilidad[] = $respuestas[4];
                $pruebaUsabilidad[] = $respuestas[5];
                $pruebaUsabilidad[] = $respuestas[6];
                $pruebaUsabilidad[] = $respuestas[7];
                $pruebaUsabilidad[] = $respuestas[8];
                $pruebaUsabilidad[] = $respuestas[9];
                $pruebaUsabilidad[] = $respuestas[10];
            } else {
                for($i=0; $i<2; $i++) { $pruebaUsabilidad[] = "-"; }
            }

            if ($observacionesFacilitador) {
                $pruebaUsabilidad[] = $observacionesFacilitador['id_observacion'];
                $pruebaUsabilidad[] = $observacionesFacilitador['comentarios_facilitador'];
            } else {
                for($i=0; $i<2; $i++) { $pruebaUsabilidad[] = "-"; }
            }
            fputcsv($archivoExportado, $pruebaUsabilidad, ";");
        }
        $consultaObtenerGenero->close();
        $consultaResultado->close();
        $consultaObtenerDispositivo->close();
        $consultaObservacionesFacilitador->close();

        fclose($archivoExportado);
    }

    public function guardarUsuario($edad, $profesion, $genero, $pericia){
        $consultaInsertarUsuario = $this->db->prepare("INSERT INTO usuario (edad, profesion, id_genero, pericia) VALUES (?, ?, ?, ?)");
        $id_genero = $this->buscarIdGenero($genero);
        $consultaInsertarUsuario->bind_param("isii", $edad, $profesion, $id_genero, $pericia);
        $consultaInsertarUsuario->execute();
        $id_usuario = $this->db->insert_id;
        return $id_usuario;
    }

    public function buscarIdGenero($nombreGenero){
        $consutaObtenerId = $this->db->prepare("SELECT id_genero FROM genero WHERE nombre = ?");
        $consutaObtenerId->bind_param("s", $nombreGenero);
        $consutaObtenerId->execute();
        $resultado = $consutaObtenerId->get_result();
        if ($fila = $resultado->fetch_assoc()) {
            $consutaObtenerId->close();
            return $fila['id_genero']; 
        } else {
            $consutaObtenerId->close();
            return null; 
        }
    }

    public function guardarResultados($id_usuario, $dispositivo, $valoracion, $propuestas, $comentarios, $tiempo, $completado,$lista_respuestas) {  
        $consultaInsertarResultados = $this->db->prepare("INSERT INTO resultado (id_usuario, id_dispositivo, tiempo_empleado, completado, comentarios_usuario, propuestas_mejora, valoracion) 
                                                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $id_dispositivo = $this->buscarIdDispositivo($dispositivo);
        $consultaInsertarResultados->bind_param("iidissi", $id_usuario, $id_dispositivo, $tiempo, $completado, $comentarios, $propuestas, $valoracion);
        $consultaInsertarResultados->execute();
        $id_resultado = $this->db->insert_id;
        $consultaInsertarResultados->close();

        $consultaRespuestas = $this->db->prepare("INSERT INTO respuesta (id_resultado, numero_pregunta, valor_respuesta) VALUES (?, ?, ?)");
        $numeroPregunta = 1;
        $respuestaPreguntaActual = "";
        $consultaRespuestas->bind_param("iis", $id_resultado, $numeroPregunta, $respuestaPreguntaActual);
        foreach ($lista_respuestas as $respuesta) {
            $respuestaPreguntaActual = $respuesta;
            $consultaRespuestas->execute();
            $numeroPregunta++;
        }
        $consultaRespuestas->close();
        return $id_resultado;
    }

    public function actualizarResultado($id_resultado,$tiempo,$valoracion,$propuestas,$comentarios,$completado,$lista_respuestas) {
        $consultaActualizarResultados = $this->db->prepare("UPDATE resultado SET tiempo_empleado = ?,valoracion = ?,propuestas_mejora = ?,comentarios_usuario = ?,completado = ? WHERE id_resultado = ?");


        $consultaActualizarResultados->bind_param("dissii",$tiempo,$valoracion,$propuestas,$comentarios,$completado,$id_resultado);
        $consultaActualizarResultados->execute();
        $consultaActualizarResultados->close();
        $consultaRespuestas = $this->db->prepare(
            "UPDATE respuesta 
             SET valor_respuesta = ? 
             WHERE id_resultado = ? AND numero_pregunta = ?"
        );

        $numeroPregunta = 1;
        $respuestaPreguntaActual = "";
        $consultaRespuestas->bind_param("sis", $respuestaPreguntaActual, $id_resultado, $numeroPregunta);

        foreach ($lista_respuestas as $respuesta) {
            $respuestaPreguntaActual = $respuesta;
            $consultaRespuestas->execute();
            $numeroPregunta++;
        }
        $consultaRespuestas->close();
    }

    public function buscarIdDispositivo($nombreDispositivo){
        $consultaObtenerId = $this->db->prepare("SELECT id_dispositivo FROM dispositivo WHERE nombre = ?");
        $consultaObtenerId->bind_param("s", $nombreDispositivo);
        $consultaObtenerId->execute();
        $resultado = $consultaObtenerId->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            $consultaObtenerId->close();
            return $fila['id_dispositivo']; 
        } else {
            $consultaObtenerId->close();
            return null;
        }
    }

    public function guardarObservacionesFacilitador($id_usuario,$observaciones){
        $consultaInsertarObservaciones = $this->db->prepare("INSERT INTO observacion_facilitador (id_usuario, comentarios_facilitador) VALUES (?, ?)");
        $consultaInsertarObservaciones->bind_param("is", $id_usuario, $observaciones);
        $consultaInsertarObservaciones->execute();
        $consultaInsertarObservaciones->close();
    }
}
?>