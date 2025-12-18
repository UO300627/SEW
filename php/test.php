<?php 
require_once '../classCrono.php';
require_once 'classConfiguracion.php';

session_start();

$crono = new Cronometro();
$configuracion = new Configuracion();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['id_usuario_actual'])) {
    session_unset();
    session_destroy();
    session_start();

    $crono = new Cronometro();
    $configuracion = new Configuracion();
}

$vista_a_mostrar = 'guardarUsuario.php'; 

$mostrarInicio = true;
$mostrarPreguntas = false;
$mostrarFinal = false;

if (isset($_SESSION['id_usuario_actual'])) {
    $estado = $_SESSION['estado_test'] ?? 'inicio';

    if ($estado === 'facilitador') {
        $vista_a_mostrar = 'guardarObservacionFacilitador.php';
    } else {
        $vista_a_mostrar = 'formulario.php';
        if ($estado === 'preguntas') {
            $mostrarInicio = false;
            $mostrarPreguntas = true;
        } elseif ($estado === 'final') {
            $mostrarInicio = false;
            $mostrarPreguntas = false;
            $mostrarFinal = true;
        }
    }
}


if (isset($_POST['datos_usuario'])) {
    $id_creado = $configuracion->guardarUsuario($_POST['edad'], $_POST['profesion'], $_POST['genero'], $_POST['pericia']); 
    $_SESSION['id_usuario_actual'] = $id_creado;
    $_SESSION['dispositivo_utilizado'] = $_POST['dispositivo'];
    $_SESSION['estado_test'] = 'inicio';
    $respuestas_vacias = [null, null, null, null, null, null, null, null, null, null];

    $_SESSION['id_resultado'] = $configuracion->guardarResultados(
        $_SESSION['id_usuario_actual'],
        $_SESSION['dispositivo_utilizado'],
        null,
        null,
        null,
        null,
        false,
        $respuestas_vacias
    );
    $vista_a_mostrar = 'formulario.php';
    $mostrarInicio = true; 
}

if (isset($_POST['arrancar'])) {
    $crono->arrancar();
    $_SESSION['estado_test'] = 'preguntas';
    $mostrarInicio = false;
    $mostrarPreguntas = true;
    $vista_a_mostrar = 'formulario.php';
}

if (isset($_POST['parar'])) {
    $crono->parar();
    $_SESSION['tiempo_final'] = $_SESSION['tiempoTranscurrido'];
    $_SESSION['estado_test'] = 'final';
    $_SESSION['respuestas'] = [
        'r1'  => $_POST['piloto'], 'r2'  => $_POST['equipo'],
        'r3'  => $_POST['puntos'], 'r4'  => $_POST['carrusel'],
        'r5'  => $_POST['noticias'], 'r6'  => $_POST['circuito'],
        'r7'  => $_POST['meteorologia'], 'r8'  => $_POST['ganador'],
        'r9'  => $_POST['primero'], 'r10' => $_POST['juegos']
    ]; 
    $configuracion->actualizarResultado($_SESSION['id_resultado'],$_SESSION['tiempo_final'],null,
        null,null,false,$_SESSION['respuestas']);
    $mostrarInicio = false;
    $mostrarPreguntas = false;
    $mostrarFinal = true;
    $vista_a_mostrar = 'formulario.php';
}

if (isset($_POST['guardar_resultados'])) {
     $configuracion->actualizarResultado($_SESSION['id_resultado'],$_SESSION['tiempo_final'],$_POST['valoracion'],
        $_POST['propuestas'],$_POST['comentarios'],true,$_SESSION['respuestas']);
    
    $_SESSION['estado_test'] = 'facilitador'; 
    $vista_a_mostrar = 'guardarObservacionFacilitador.php';
}

if (isset($_POST['guardar_facilitador'])) {
    $id_usuario = $_SESSION['id_usuario_actual'];
    $observaciones_facilitador = $_POST['observaciones_facilitador'];

    $configuracion->guardarObservacionesFacilitador($id_usuario, $observaciones_facilitador);
    
    session_unset();
    session_destroy();
    session_start();
    
    $vista_a_mostrar = 'guardarUsuario.php';
}

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>MotoGP-Formulario</title>
    <meta name="autor" content ="Adrián Gutiérrez García"/>
    <meta name="viewport" content = "width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css" />
    <link rel="icon" type="text/css" href="../multimedia/favicon.ico" />
</head>
<body>
    <header>
        <h1>MotoGP Desktop</h1>
    </header>

    <main>
        <?php include $vista_a_mostrar; ?>
    </main>
</body>
</html>