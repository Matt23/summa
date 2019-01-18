   <div class="wrapper">
      <div class="abs-center wd-xl">

      	<h4>Agregar empleado</h4>
         <form action="{path}empleados/agregar" method="post">
         	<input type="text" name="nombre" placeholder="Nombre" required ><br>
			<input type="text" name="apellido" placeholder="Apellido" required ><br>
			<input type="text" name="edad" placeholder="Edad" required ><br>
			<select name="tipo" onChange="empleadotipo();" id="tipoempleado" required><br>
				<option value="" selected="false" disabled>Tipo de empleado</option>
				<option value="1">Programador</option>
				<option value="2">Diseñador</option>
			</select>

			<select name="textoprogramador" id="textoprogramador" style="display: none;"><br>
				<option value="1">PHP</option>
				<option value="2">NET</option>
				<option value="3">Phyton</option>
			</select>

			<select name="textodesigner" id="textodesigner" style="display: none;"><br>
				<option value="1">Gráfico</option>
				<option value="2">Web</option>
			</select>

			<input type="submit" value="Agregar">

         </form>
         <script type="text/javascript">
         	function empleadotipo() {
         		if ($( "#tipoempleado option:selected" ).val() == 1 ) {
         			$('#textoprogramador').css('display','block');
         			$('#textodesigner').css('display','none');
         		} else {
         			$('#textoprogramador').css('display','none');
         			$('#textodesigner').css('display','block');
         		}
         	}
         </script>
      </div>
   </div>