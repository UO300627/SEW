<?php
class Cronometro{
   
    private $tiempo;
    public function __construct(){
        $this->tiempo = 0;
    }

    public function arrancar(){
        $_SESSION['tiempo'] = microtime(true);
    }

    public function parar(){
        if(isset($_SESSION['tiempo'])) {
            $tiempoActual = microtime(true);
            $_SESSION['tiempoTranscurrido'] = $tiempoActual - $_SESSION['tiempo'];
            
            unset($_SESSION['tiempo']);
        }
    }

    public function mostrar(){
        $tiempoTotal = 0;

        if(isset($_SESSION['tiempoTranscurrido'])) {
            $tiempoTotal = $_SESSION['tiempoTranscurrido'];
        } 
        elseif(isset($_SESSION['tiempo'])) {
            $tiempoTotal = microtime(true) - $_SESSION['tiempo'];
        }

        $minutos = floor($tiempoTotal / 60);
        $segundos = $tiempoTotal - ($minutos * 60);

        return sprintf("%02d:%04.1f", $minutos, $segundos);
    }
}
?>