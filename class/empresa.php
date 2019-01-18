<?php
class empresa {

	private $tpl;
	private $mysql;

    private $promedioedades;
    private $nombreempresa;
    private $cantiempleados;

	public function __construct() {

        $this->tpl = new tplClass();
        $this->mysql = new mysql();

        $query = "select nombre, empleados from empresa ; ";

        try{
            $rs = $this->mysql->runQuery($query);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        $query2 = "select edad from empleados ; ";

        try{
            $rs2 = $this->mysql->runQuery($query2);
        } catch(Exception $e) {
            die($e->getMessage());
        }

        foreach ($rs2 as $key => $reg) {
            $sumaedades = $sumaedades + $reg['edad'];
            $contador ++;
        }

        $this->__set('promedioedades', number_format($sumaedades/$contador,0));
        $this->__set('nombreempresa', $rs[0]['nombre']);
        $this->__set('cantiempleados', $rs[0]['empleados']);

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

    function header($get=null,$post=null,$params=null) {

        $datos['path'] = INSTALLPATH;
        $datos['empresa'] = $this->__get('nombreempresa');
        $datos['empleados'] = $this->__get('cantiempleados');
        $datos['promedioedades'] = $this->__get('promedioedades');

        echo $this->tpl->printTemplate("header", $datos);
        echo $this->tpl->printTemplate("empresa", $datos);        
    }

    function footer() {
        echo $this->tpl->printTemplate("footer", $datos);        
    }

	function dashboard($get=null,$post=null,$params=null) {

        $empleados = new empleados();
        $this->header();
        $empleados->listar();
        $this->footer();
	}

    function buscar($get=null,$post=null,$params=null) {

        $empleados = new empleados();
        $this->header();
        $empleados->buscar($get, $post, $params);
        $this->footer();
    }
}
?>