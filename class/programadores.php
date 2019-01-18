<?php
class programadores extends empleados {

	private $tpl;
	private $mysql;

	public function __construct() {

        $this->tpl = new tplClass();
        $this->mysql = new mysql();
	}

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

	function listar($get=null,$post=null,$params=null) {

        $query = "select empl.*, devs.lenguaje, lng.nombre as nmb
        from empleados empl 
        inner join programadores devs on empl.id = devs.id 
        inner join lenguajes lng on devs.lenguaje = lng.id 
        where empl.tipo = 1 order by apellido asc, nombre asc ; ";

        try{
            $rs = $this->mysql->runQuery($query);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $datos['path'] = INSTALLPATH;
        
        $datos['listaempleados'] = "<table style='margin:20px auto;text-align:left;'><tr><td style='padding:10px 25px;'><b>Nombre</b></td><td style='padding:10px 25px;'><b>Apellido</b></td><td style='padding:10px 25px;'><b>Edad</b></td><td style='padding:10px 25px;'><b>Tipo</b></td><td></td></tr>";

        foreach ($rs as $empleado => $reg) {
            $datos['listaempleados'] .= "<tr><td style='padding:10px 25px;'>".$reg['nombre']."</td>";
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>".$reg['apellido']."</td>";
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>".$reg['edad']."</td>"; 
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>" . ($reg['tipo'] ==1 ? "Programador" : "Diseñador") . " " . $reg['nmb'] . "</td><td style='padding:10px 25px'><a href='".INSTALLPATH."empleados/eliminar/".$reg['id']."'>Eliminar</a></td></tr>";
        }
        
        $datos['listaempleados'] .= "</table>";
            
        $empresa = new empresa();

        echo $empresa->header();
        echo $this->tpl->printTemplate("empleadoslistar", $datos);
        echo $empresa->footer();
	}
}
?>