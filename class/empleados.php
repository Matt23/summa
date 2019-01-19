<?php
class empleados {

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

    function buscar($get=null,$post=null,$params=null) {

        $query = "select id, nombre, apellido, edad, tipo from empleados where id = :id order by apellido asc, nombre asc ; ";

        $vars['id'] = $post['buscarid'];

        try{
            $rs = $this->mysql->runQuery($query, $vars);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $datos['path'] = INSTALLPATH;
        
        $datos['listaempleados'] = "<table style='margin:20px auto;text-align:left;'><tr><td style='padding:10px 25px;'><b>Nombre</b></td><td style='padding:10px 25px;'><b>Apellido</b></td><td style='padding:10px 25px;'><b>Edad</b></td><td style='padding:10px 25px;'><b>Tipo</b></td><td></td></tr>";

        foreach ($rs as $empleado => $reg) {
            $datos['listaempleados'] .= "<tr><td style='padding:10px 25px;'>".$reg['nombre']."</td>";
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>".$reg['apellido']."</td>";
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>".$reg['edad']."</td>"; 
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>" . ($reg['tipo'] == 1 ? "Programador" : "Diseñador") . "</td></tr>";
        }
        $datos['listaempleados'] .= "</table>";

        echo $this->tpl->printTemplate("empleadoslistar", $datos);        
    }

	function listar($get=null,$post=null,$params=null) {

        $query = "select id, nombre, apellido, edad, tipo from empleados order by apellido asc, nombre asc ; ";

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
            $datos['listaempleados'] .= "<td style='padding:10px 25px;'>" . ($reg['tipo'] ==1 ? "Programador" : "Diseñador") . "</td></tr>";
        }
        $datos['listaempleados'] .= "</table>";
            
        echo $this->tpl->printTemplate("empleadoslistar", $datos);
	}

    function agregar ($get=null,$post=null,$params=null) {
        
        if ($post) { 
            $query = "insert into empleados (nombre, apellido, edad, tipo) values (:nombre, :apellido, :edad, :tipo ) ; ";

            $vars['nombre'] = $post['nombre'];
            $vars['apellido'] = $post['apellido'];
            $vars['edad'] = $post['edad'];      
            $vars['tipo'] = $post['tipo'];

            try{
                $rs = $this->mysql->runQuery($query, $vars);
            } catch(Exception $e) {
                die($e->getMessage());
            }            

            if ($post['tipo']==1) {
                $query2 = "insert into programadores (id, lenguaje) values (:id, :lenguaje ) ; ";
                $vars2['id'] = $rs;
                $vars2['lenguaje'] = $post['textoprogramador'];
            } else {
                $query2 = "insert into designers (id, tipo) values (:id, :tipo ) ; ";
                $vars2['id'] = $rs;
                $vars2['tipo'] = $post['textodesigner'];                
            }

            try{
                $rs2= $this->mysql->runQuery($query2, $vars2);
            } catch(Exception $e) {
                die($e->getMessage());
            }   

            $query3 = "select id from empleados ; ";

            try{
                $rs3 = $this->mysql->runQuery($query3);
            } catch(Exception $e) {
                die($e->getMessage());
            }

            $query4 = "update empresa set empleados = :empleados ; ";
            $vars4['empleados'] = count($rs3);

            try{
                $rs4 = $this->mysql->runQuery($query4, $vars4);
            } catch(Exception $e) {
                die($e->getMessage());
            }

            header('Location:'.INSTALLPATH.'empresa/dashboard');
        }

        $empresa = new empresa();
        $empresa->header();
        $datos['path'] = INSTALLPATH;
        echo $this->tpl->printTemplate("empleadosagregar", $datos);
        $empresa->footer();       

    }

    function eliminar($get=null,$post=null,$params=null) {

        $this->mysql = new mysql();

        $query = "delete from empleados where id = :id ;";
        $vars['id'] = $params[0];

        try{
            $rs = $this->mysql->runQuery($query, $vars);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $query = "delete from programadores where id = :id ;";
        $vars['id'] = $params[0];

        try{
            $rs = $this->mysql->runQuery($query, $vars);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $query = "delete from designers where id = :id ;";
        $vars['id'] = $params[0];

        try{
            $rs = $this->mysql->runQuery($query, $vars);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $query3 = "select id from empleados ; ";

        try{
            $rs3 = $this->mysql->runQuery($query3);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $query4 = "update empresa set empleados = :empleados ; ";
        $vars4['empleados'] = count($rs3);

        try{
            $rs4 = $this->mysql->runQuery($query4, $vars4);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        header('Location:'.INSTALLPATH.'empresa/dashboard');

    }
}
?>