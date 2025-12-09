<?php
require_once 'classConfiguracion.php';
session_start();

if (isset($_SESSION['id_usuario_actual'])) { 
    
    $config = new Configuracion();
    $id_usuario = $_SESSION['id_usuario_actual'];
    $estado = $_SESSION['estado_test'] ?? 'desconocido';
    

    if ($estado === 'preguntas') {
        $config->guardarResultados($id_usuario, null, null, null, null, null, false);
    }
    
    elseif ($estado === 'final') {
        $tiempo_empleado = $_SESSION['tiempoTranscurrido'] ?? 0;
        $config->guardarResultados($id_usuario, null, null, null, null, $tiempo_empleado, false);
    }
    
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
}
?>