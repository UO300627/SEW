<form action="#" method="post">
    <p>Introduzca las observaciones relativas a la prueba se usabilidad realizada por el usuario:</p>
    <textarea name="observaciones_facilitador" rows="6" cols="50" required ></textarea>      
    <p><input type="submit" name="guardar_facilitador" value="Guardar y finializar test" /></p>
</form>

<script>
    let esSalidaLegal = false;

    const botonGuardar = document.querySelector('input[type="submit"]');
    
    if (botonGuardar) {
        botonGuardar.addEventListener('click', function() {
            esSalidaLegal = true;
        });
    }

    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'hidden' && !esSalidaLegal) {
            
            const datos = new FormData();
            datos.append('motivo', 'abandono_facilitador');
            navigator.sendBeacon('guardarAbandono.php', datos);
        }
    });
</script>