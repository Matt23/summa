   <div class="wrapper">
      <div class="abs-center wd-xl">
         <!-- START panel-->
         <div class="panel widget b0">
            <div class="panel-body">
               <p class="text-center"><h1>{empresa}</h1><h2>{empleados} empleados</h2><h5>Promedio de edad: {promedioedades} años.</h5></p>
               <a href="{path}">Dashboard</a> | <a href="{path}programadores/listar">Listar Programadores</a> | <a href="{path}designers/listar">Listar Diseñadores</a> | <a href="{path}empleados/agregar">Agregar empleado</a> 
               <div>
                  <form action="{path}empresa/buscar" method="post"><input type="text" name="buscarid" placeholder="Buscar empleado por Id" required></form>--------------------------------------------------
               </div>
            </div>
         </div>
      </div>
   </div>