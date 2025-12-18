<?php
require_once 'classCrono.php';
session_start();
$cronometro = new Cronometro();
$mensaje = "00:00.0";

if (count($_POST) > 0) {
    if(isset($_POST['arrancar'])){
        $cronometro->arrancar();
        $mensaje = "cronómetro iniciado";
    } 
    if(isset($_POST['parar'])){
        $cronometro->parar();
        $mensaje = "cronómetro parado";
    }    
    if(isset($_POST['mostrar'])){
        $mensaje = $cronometro->mostrar();
    } 
}
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>MotoGP-Cronómetro PHP</title>
    <meta name="autor" content="Adrián Gutiérrez García" />
    <meta name="description" content="Cronómetro para tiempos de vuelta" />
    <meta name="keywords" content="cronometro, motogp, tiempos" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="text/css" href="multimedia/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="estilo/layout.css" />
</head>

<body>
   <header> 
        <h1><a href="index.html">MotoGP Desktop</a></h1>
        <nav>
            <a href="index.html" title="Información de inicio">Inicio</a>
            <a href="piloto.html" title="Información del piloto">Piloto</a>
            <a href="circuito.html" title="Información del circuito">Circuito</a>
            <a href="meteorologia.html" title="Información de la meteorología">Meteorología</a>
            <a href="clasificaciones.php" title="Información de las clasificaciones">Clasificaciones</a>
            <a class = "active" href="juegos.html" title="Información de los juegos">Juegos</a>
            <a href="ayuda.html" title="Información de la ayuda">Ayuda</a>
        </nav>
    </header>

    <p>Estás en: <a href="index.html">Inicio</a> >> <a href="juegos.html">Juegos</a> >> <strong>Cronómetro PHP</strong></p>
    <main>
        <h2>Cronómetro PHP</h2>
        
        <section>
            <h3><?= $mensaje ?></h3>

            <form action="#" method="post">
                <p>
                    <input type="submit" name="arrancar" value="Arrancar" />
                    <input type="submit" name="parar" value="Parar" />
                    <input type="submit" name="mostrar" value="Mostrar" />
                </p>
            </form>
        </section>
    </main>
</body>
</html>