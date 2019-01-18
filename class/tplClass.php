<?php
/**
* Matías / 2016
*/
class tplClass{

	public $arrData = Array();

	function file($template_file){

		@session_start();
		$this->tpl_file = dirname(__FILE__) . '/../templates/'. $_SESSION['lang'] . $template_file . '.tpl';
	}

	function muestra(){

		if (!($this->fd = @fopen($this->tpl_file, 'r'))) {

			echo '<pre>Error al abrir el template ' . $this->tpl_file . '</pre>';

		} else {

			$this->template_file = fread($this->fd, filesize($this->tpl_file));

			fclose($this->fd);

			$this->mihtml = $this->template_file;

			$this->mihtml = str_replace ("'", "\'", $this->mihtml);

			// Reemplazo {x} por ' . $x . ' en el archivo con el template:
			$this->mihtml = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . $\\1 . '", $this->mihtml); 

			reset ($this->arrData);

			// Recorro el array de datos, y el contenido de cada índice lo guardo en variables. 
			// Cada variable tiene el nombre del índice.
			// Por ejemplo, el contenido de $this->arrData['x'] lo guardo en $x.
			while (list($key, $val) = each($this->arrData)) {
				$$key = $val;
			}

			// En $this->mihtml, reemplazo ' . $x . ' por el contenido guardado en $x:
			eval("\$this->mihtml = '$this->mihtml';");

			reset ($this->arrData);

			while (list($key, $val) = each($this->arrData)) {
				unset($$key);
			}

			$this->mihtml=str_replace ("\'", "'", $this->mihtml);

			return $this->mihtml;

		}
	}

	function printTemplate($file,$data=null) {

		$this->file($file);

		if(is_Array($data)){
			$this->arrData = $data;
		} else {
			$this->arrData = array();
		}

		return $this->muestra();
	}

}



?>