<?php
class Clasificacion{
    private $documento;
    public $xml;
    public function __construct(){
        $this->documento =__DIR__ . '/xml/circuitoEsquema.xml';
        $this->xml = null;
    }

    public function consultar(){
        $datos = file_get_contents($this->documento);
        if($datos==null) {
            return false;
        } else {
            $datos =preg_replace("/>\s*</",">\n<",$datos);
            $this->xml = new SimpleXMLElement($datos);
            return true;
        }
        
    }

    public function formatearDuracion($duracion){
        $milisegundos = 0;
        $duracionParaInterval = $duracion;

        if (preg_match('/(\d+\.\d+)S$/', $duracion, $segundos)) {
            $segundosTotales = (float)$segundos[1];
            
            $segundosEnteros = floor($segundosTotales);
            $milisegundos = round(($segundosTotales - $segundosEnteros) * 1000);

            $duracionParaInterval = preg_replace('/(\d+\.\d+)S$/', $segundosEnteros . 'S', $duracion);
        }
        $intervalo = new DateInterval($duracionParaInterval);
        $horasTotales = $intervalo->d * 24 + $intervalo->h;

        $resultado = sprintf('%02d:%02d:%02d.%03d', $horasTotales,$intervalo->i,$intervalo->s,$milisegundos);
        return $resultado;
    }
}

$clasificacion = new Clasificacion();
$estadoValido = $clasificacion->consultar();
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>MotoGP-Clasificaciones</title>
    <meta name="autor" content ="Adrián Gutiérrez García"/>
    <meta name="description" content="Información acerca de la clasificación
    del mundial de MotoGP 2025"/>
    <meta name ="keywords" content ="pole, podium" /> 
    <meta name="viewport" content = "width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="estilo/layout.css" />
    <link rel="icon" type="text/css" href="multimedia/favicon.ico" />
</head>

<body>
     <header>
        <h1><a href="index.html">MotoGP Desktop</a></h1>
        
        <nav>
            <a href="index.html" title="Información de inicio">Inicio</a>
            <a href="piloto.html" title="Información del piloto">Piloto</a>
            <a href="circuito.html" title="Información del circuito">Circuito</a>
            <a href="meteorologia.html" title="Información de la meteorología">Meteorología</a>
            <a class = "active" href="clasificaciones.php" title="Información de las clasificaciones">Clasificaciones</a>
            <a href="juegos.html" title="Información de los juegos">Juegos</a>
            <a href="ayuda.html" title="Información de la ayuda">Ayuda</a>
        </nav>
    </header>

    <p>Estás en: <a href="index.html">Inicio</a> >> <strong>Clasificaciones</strong></p>

    <main>
        <h2>Clasificaciones</h2>
        <?php
        if($estadoValido): ?>
            <?php $xml = $clasificacion->xml;?>
            <section>
                <h3>Ganador de la carrera</h3>
                <?php
                    $ganador = $xml->vencedor;
                    $tiempoEmpleado = $clasificacion->formatearDuracion($xml->vencedor['tiempoEmpleado']);
                ?>
                <p>Ganador de la carrera: <?=$ganador?></p>
                <p>Tiempo empleado para terminar la carrera: <?=$tiempoEmpleado?> </p>
            </section>
            <section>
                <h3>Clasificación del mundial tras la carrera</h3>
                <?php
                    $primero = $xml->clasificacionGeneral->primero;
                    $segundo = $xml->clasificacionGeneral->segundo;
                    $tercero = $xml->clasificacionGeneral->tercero;
                ?>
                <p>Clasifiación:</p>
                <ol>
                    <li><?=$primero?></li>
                    <li><?=$segundo?></li>
                    <li><?=$tercero?></li>
                </ol>
            </section>
        <?php
        else: ?>
           <p>Error en el archivo XML recibido</p>
        <?php endif; ?>
    </main>
</body>
</html>