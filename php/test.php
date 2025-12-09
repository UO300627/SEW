<?php 
require_once '../classCrono.php';
require_once 'classConfiguracion.php';
session_start();

$crono = new Cronometro();
$configuracion = new Configuracion();

$vista_a_mostrar = 'guardarUsuario.php'; 

$mostrarInicio = true;
$mostrarPreguntas = false;
$mostrarFinal = false;
$mensajePreguntasNoRespondidas = "";

if (isset($_SESSION['id_usuario_actual'])) {
    $vista_a_mostrar = 'formulario.php'; 
    
    $estado = $_SESSION['estado_test'] ?? 'inicio';

    if ($estado === 'facilitador') {
        $vista_a_mostrar = 'guardarObservacionFacilitador.php';
    } else {
        $vista_a_mostrar = 'formulario.php';
        if (isset($_SESSION['estado_test'])) {
            if ($_SESSION['estado_test'] === 'preguntas') {
                $mostrarInicio = false;
                $mostrarPreguntas = true;
            }
            if ($_SESSION['estado_test'] === 'final') {
                $mostrarInicio = false;
                $mostrarPreguntas = false;
                $mostrarFinal = true;
            }
        }
    }
}

if (isset($_POST['datos_usuario'])) {
    $id_creado = $configuracion->guardarUsuario($_POST['edad'], $_POST['profesion'], $_POST['genero'], $_POST['pericia']); 
    $_SESSION['id_usuario_actual'] = $id_creado;
    $_SESSION['estado_test'] = 'inicio';
    $vista_a_mostrar = 'formulario.php';
}

if (isset($_POST['arrancar'])) {
    $crono->arrancar();
    $_SESSION['estado_test'] = 'preguntas';   
    $mostrarInicio = false;
    $mostrarPreguntas = true;
}

if (isset($_POST['parar'])) {
    $crono->parar();
    $_SESSION['tiempo_final'] = $_SESSION['tiempoTranscurrido'] ?? 0;
    $_SESSION['estado_test'] = 'final'; 
    
    $mostrarInicio = false;
    $mostrarPreguntas = false;
    $mostrarFinal = true;
}

if (isset($_POST['guardar_resultados'])) {
    $id_usuario = $_SESSION['id_usuario_actual'];
    $tiempo_final = $_SESSION['tiempo_final'];

    $dispositivo = !empty($_POST['dispositivo']) ? $_POST['dispositivo'] : null;
    $valoracion = (isset($_POST['valoracion']) && $_POST['valoracion'] !== "") ? $_POST['valoracion'] : null;
    $propuestas = !empty($_POST['propuestas']) ? $_POST['propuestas'] : null;
    $comentarios = !empty($_POST['comentarios']) ? $_POST['comentarios'] : null;

    $configuracion->guardarResultados($id_usuario, $dispositivo, $valoracion, $propuestas, $comentarios, $tiempo_final,true);
    $_SESSION['estado_test'] = 'facilitador'; 
    $vista_a_mostrar = 'guardarObservacionFacilitador.php';   
}

if (isset($_POST['guardar_facilitador'])) {
    $id_usuario = $_SESSION['id_usuario_actual'];
    $observaciones_facilitador = $_POST['observaciones_facilitador'];

    $configuracion->guardarObservacionesFacilitador($id_usuario,$observaciones_facilitador);
    session_destroy();
    header("Location: test.php");
    exit;
}


?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>MotoGP-Formulario</title>
    <meta name="autor" content ="Adrián Gutiérrez García"/>
    <meta name="description" content="Prueba de usabilidad"/>
    <meta name ="keywords" content ="preguntas, usuario" /> 
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