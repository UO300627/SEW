<h2>Formulario MotoGP</h2>
        
<form action="#" method="post" name="formulario">
    <?php if ($mostrarInicio) { ?>
        <p>Pulse el botón para comenzar el test.</p>
        <p><input type="submit" name="arrancar" value="Iniciar Prueba" /></p>
    <?php } ?>
    <?php if ($mostrarPreguntas) { ?>
        <p><input type="submit" name="arrancar" value="Iniciar Prueba" /></p>
            <p>Responde a las 10 preguntas:</p>
            <p>1. ¿Cual es el nombre del piloto sobre el que se muestra información?</p>
            <p><input type="text" name="piloto" required/></p>

            <p>2. ¿En que equipo está actualmente dicho piloto?</p>
            <p><input type="text" name="equipo" required/></p>

            <p>3. ¿Cuantos puntos ha obtenido en la temporada 2024?</p>
            <p><input type="text" name="puntos" required/></p>

            <p>4. ¿Cuantas fotos aparecen en el carrusel de la pantalla de inicio?</p>
            <p><input type="text" name="carrusel" required/></p>

            <p>5. ¿Cuantas noticias aparecen en la pantalla de inicio?:</p>
            <p><input type="text" name="noticias" required/></p>

            <p>6. ¿Sobre que circuito se muestra información?</p>
            <p><input type="text" name="circuito" required/></p>

            <p>7. ¿De que días se muestran los datos meteorológicos?</p>
            <p><input type="text" name="meteorologia" required/></p>

            <p>8. ¿Quién fue el ganador de la carrera sobre la que se habla?</p>
            <p><input type="text" name="ganador" required/></p>

            <p>9. ¿Quién ocupaba el primer puesto en la clasificación general tras dicha carrera?</p>
            <p><input type="text" name="primero" required/></p>

            <p>10. ¿Cuantas opciones para seleccionar hay en el menú de juegos?</p>
            <p><input type="text" name="juegos" required/></p>
                
            <p><input type="submit" name="parar" value="Terminar Prueba" /></p>
        <?php } ?>
        <?php if ($mostrarFinal) { ?>
            <p>Rellene los siguientes datos adicionales (opcionales):</p>
            <p>Dispositivo utilizado:</p>
			<p>
				<select name="dispositivo" >
					<option value="" disabled selected>-- Seleccione uno --</option>
					<option value="ordenador">Ordenador</option>
					<option value="tableta">Tableta</option>
					<option value="telefono">Teléfono</option>
				</select>
			</p>

			<p>Valoración global (0 al 10):</p>
			<p><input type="number" name="valoracion" min="0" max="10" /></p>

			<p>Propuestas de mejora:</p>
			<textarea name="propuestas" rows="5" cols="40" ></textarea>

			<p>Otros comentarios:</p>
			<textarea name="comentarios" rows="5" cols="40" ></textarea>

			<p><input type="submit" name="guardar_resultados" value="Guardar resultados" /></p>
        <?php } ?>
</form>

<script>
    let esNavegacionLegal = false;

    const botones = document.querySelectorAll('input[type="submit"]');
    
    botones.forEach(boton => {
        boton.addEventListener('click', function() {
            esNavegacionLegal = true;
        });
    });

    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'hidden' && !esNavegacionLegal) {
            
            const datos = new FormData();
            datos.append('motivo', 'abandono');

            navigator.sendBeacon('guardarAbandono.php', datos);
        }
    });
</script>

        