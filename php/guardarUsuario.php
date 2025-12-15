<h2>Introduzca sus datos</h2>
<form action="#" method="post">
    <p>Edad: <input type="number" name="edad" min="0" max="120" required></p>
    <p>Profesión: <input type="text" name="profesion" required></p>
    <p>Género: 
		<select name="genero" required>
			<option value="" disabled selected>Selecciona tu género</option>
			<option value="Masculino">Masculino</option>
			<option value="Femenino">Femenino</option>
			<option value="Otro">Otro</option>
		</select>
	</p>
    <p>Pericia: <input type="number" name="pericia" min="0" max="10" required></p>
	<p>Dispositivo utilizado: 
			<select name="dispositivo" required>
				<option value="" disabled selected>Selecciona tu dispositivo</option>
				<option value="Ordenador">Ordenador</option>
				<option value="Tableta">Tableta</option>
				<option value="Telefono">Telefono</option>
			</select>
		</p>    
    <input type="submit" name="datos_usuario" value="Guardar datos">
</form>