<h2>Formulario MotoGP</h2>
        
<form action="#" method="post" name="formulario">
    <?php if ($mostrarInicio) { ?>
        <p>Pulse el botón para comenzar el test.</p>
        <p><input type="submit" name="arrancar" value="Iniciar Prueba" /></p>
    <?php } ?>
    <?php if ($mostrarPreguntas) { ?>
        <p><input type="submit" name="arrancar" value="Iniciar Prueba" /></p>
            <p>Responde a las 10 preguntas:</p>
            <p><label for="piloto">1. ¿Cuál es el nombre del piloto sobre el que se muestra información?</label></p>
            <p><input type="text" id="piloto" name="piloto" required/></p>

            <p><label for="equipo">2. ¿En qué equipo está actualmente dicho piloto?</label></p>
            <p><input type="text" id="equipo" name="equipo" required/></p>

            <p><label for="puntos">3. ¿Cuántos puntos ha obtenido en la temporada 2024?</label></p>
            <p><input type="number" id="puntos" name="puntos" required/></p>

            <p><label for="carrusel">4. ¿Cuántas fotos aparecen en el carrusel de la pantalla de inicio?</label></p>
            <p><input type="number" id="carrusel" name="carrusel" required/></p>

            <p><label for="noticias">5. ¿Cuántas noticias aparecen en la pantalla de inicio?</label></p>
            <p><input type="number" id="noticias" name="noticias" required/></p>

            <p><label for="circuito">6. ¿Sobre que circuito se muestra información?</label></p>
            <p><input type="text" id="circuito" name="circuito" required/></p>

            <p><label for="meteorologia">7. ¿Cuál es la fecha de la carrera de la cual se muestran datos meteorológicos?</label></p>
            <p><input type="text" id="meteorologia" name="meteorologia" required/></p>

            <p><label for="ganador">8. ¿Quién fue el ganador de la carrera sobre la que se habla?</label></p>
            <p><input type="text" id="ganador" name="ganador" required/></p>

            <p><label for="primero">9. ¿Quién ocupaba el primer puesto en la clasificación general tras dicha carrera?</label></p>
            <p><input type="text" id="primero" name="primero" required/></p>

            <p><label for="juegos">10. ¿Cuántas opciones para seleccionar hay en el menú de juegos?</label></p>
            <p><input type="number" id="juegos" name="juegos" required/></p>
                
            <p><input type="submit" name="parar" value="Terminar Prueba" /></p>
        <?php } ?>
        <?php if ($mostrarFinal) { ?>
            <p>Rellene los siguientes datos adicionales:</p>

			<p><label for="valoracion">Valoración global (0 al 10):</label></p>
			<p><input type="number" id="valoracion" name="valoracion" min="0" max="10" required/></p>

			<p><label for="propuestas">Propuestas de mejora:</label></p>
			<textarea id="propuestas" name="propuestas" rows="5" cols="40" required></textarea>

			<p><label for="comentarios">Otros comentarios:</label></p>
			<textarea id="comentarios" name="comentarios" rows="5" cols="40" required></textarea>

			<p><input type="submit" name="guardar_resultados" value="Guardar resultados" /></p>
        <?php } ?>
</form>

        