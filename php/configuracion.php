<?php
require_once 'classConfiguracion.php';
session_start();
$configuracion = new Configuracion();

if (count($_POST) > 0) {
    if(isset($_POST['reiniciar'])){
        $configuracion->reiniciarBD();
    } 
    if(isset($_POST['borrar'])){
        $configuracion->borrarBD();
    }    
    if(isset($_POST['exportar'])){
        $configuracion->exportarBD();
    } 
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>MotoGP - Configuración test</title>
    <meta name="autor" content="Adrián Gutiérrez García" />
    <meta name="description" content="Configuración de la base de datos para el test" />
    <meta name="keywords" content="base de datos, reinicio, csv" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css" />
    <link rel="icon" type="text/css" href="../multimedia/favicon.ico" />
</head>

<body>
    <header> 
        <h1>MotoGP Desktop</h1>
    </header>

    <main>
        <h2>Configuración test</h2>
        
        <section>
            <h3>Opciones de configuración:</h3>
            <form action="#" method="post">
                <p>
                    <input type="submit" name="reiniciar" value="Reiniciar BD" />
                    <input type="submit" name="borrar" value="Borrar BD" />
                    <input type="submit" name="exportar" value="Exportar a CSV" />
                </p>
            </form>
        </section>
    </main>
</body>
</html>