<h2>Introduzca sus datos</h2>
<form action="#" method="post">
    <p>
		<label for="edad">Edad:</label>
		<input type="number" id="edad" name="edad" min="0" max="120" required>
	</p>
    <p>
		<label for="profesion">Profesión:</label>
		<input type="text" id="profesion" name="profesion" required>
	</p>
    <p> 
		<label for="genero">Género:</label>
		<select id="genero" name="genero" required>
			<option value="" disabled selected>Selecciona tu género</option>
			<option value="Masculino">Masculino</option>
			<option value="Femenino">Femenino</option>
			<option value="Otro">Otro</option>
		</select>
	</p>
    <p>
		<label for="pericia">Pericia:</label>
		<input type="number" id="pericia" name="pericia" min="0" max="10" required>
	</p>
	<p>
		<label for="dispositivo">Dispositivo utilizado:</label>
		<select id="dispositivo" name="dispositivo" required>
			<option value="" disabled selected>Selecciona tu dispositivo</option>
			<option value="Ordenador">Ordenador</option>
			<option value="Tableta">Tableta</option>
			<option value="Telefono">Telefono</option>
		</select>
	</p>    
    <input type="submit" name="datos_usuario" value="Guardar datos">
</form>