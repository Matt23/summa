<?php

/*  Matías / 2016

	Utilización:
	============

	$mysql = new mysql();

	$query = "select * from tabla where id = :id ; ";
	$vars['id'] = '1';

	try{
		$rs = $mysql->runQuery($query,$vars);
	} catch(Exception $e) {
		$mysql->logQuery($e, $query, $vars, 0, 1, 0); // Excepción, consulta, parámetros de consulta, mostrar x pantalla, registrar en db y enviar aviso x mail.
	}

	Base de datos:
	==============

	SET FOREIGN_KEY_CHECKS=0;
	-- ----------------------------
	-- Table structure for logquery
	-- ----------------------------
	DROP TABLE IF EXISTS `logquery`;
	CREATE TABLE `logquery` (
	  `id` int(11) NOT NULL auto_increment,
	  `ip` varchar(20) default NULL,
	  `usr` varchar(250) default NULL,
	  `fecha` datetime default NULL,
	  `file` varchar(250) default NULL,
	  `line` int(11) default NULL,
	  `msg` varchar(250) default NULL,
	  `query` text,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/

class mysql {

	private $db;
	private $errorInfo;
	private $main;

	public function __construct($host=DB_HOSTNAME, $usr=DB_USERNAME, $pwd=DB_PASSWORD, $dbname=DB_NAME) {

		try {
			$this->db = new PDO('mysql:host=' . $host . ';port=3306;dbname=' . $dbname, $usr, $pwd);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e) {
			echo '<pre>Error de conexi&oacute;n a base de datos.</pre>'; // . $e->getMessage();
		}

	}

	public function query() {

		if($this->db instanceof PDO) {
			return $this->db;
		}
	}

	public function pQuery($query,$vars=null) {

		$stmt = $this->db->prepare($query);

		if ($stmt->execute($vars)) {

			if (strtolower(substr($query, 0, 6))=='insert' || strtolower(substr($query, 0, 7))=='replace') {

				return $this->db->lastInsertId();

			} else if (strtolower(substr($query, 0, 6))=='select') {

				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $rows;

			} else {
				return true;
			}
		} else {
			print_r($stmt->errorInfo());
			$this->set_errorInfo($stmt->errorInfo());
			return false;
		}
	}

	public function set_errorInfo($var) {
		$this->errorInfo = $var;
	}

	public function get_errorInfo() {
		return $this->errorInfo;
	}

	function runQuery($query,$vars=null) {

	    $q = $this->pQuery($query,$vars);		    

	    if ($q === false) {		
	        throw new Exception($this->get_errorInfo());
	    }
	    return $q;
	}

	function logQuery($excep, $queryError, $varsError, $mostrar=null, $registrar=null, $mail=1) {

		$query = "insert into logquery (ip, url, usr, fecha, file, line, msg, query) 
					values  (:ip, :url, :usr, :fecha, :file, :line, :msg, :query) ;" ;

		$this->main    = new main();
		$vars['ip']    = $this->main->getClientIP();
		$vars['url']   = $this->main->getFullURL();
		$vars['usr']   = $_SESSION['user_name'];
		$vars['fecha'] = date("Y-m-d H:i:s");
		$vars['file']  = $excep->getFile();
		$vars['line']  = $excep->getLine();
		$vars['msg']   = $excep->getMessage();
		$vars['query'] = 'Consulta: ' . $queryError . "\r\n" . 'Parámetros: ' . json_encode($varsError);

    	$xPantalla .= '<pre>'; 
    	$xPantalla .= 'Ip:&nbsp;&nbsp;&nbsp;&nbsp;' . $vars['ip'];
    	$xPantalla .= '<br>';
    	$xPantalla .= 'Usr:&nbsp;&nbsp;&nbsp;' . $vars['usr'];
    	$xPantalla .= '<br>';
    	$xPantalla .= 'Fecha:&nbsp;' . $vars['fecha'];
    	$xPantalla .= '<br>';
    	$xPantalla .= 'File:&nbsp;&nbsp;' .  $vars['file'];
    	$xPantalla .= '<br>';
    	$xPantalla .= 'Line:&nbsp;&nbsp;' .  $vars['line'];
    	$xPantalla .= '<br>';
    	$xPantalla .= 'Msg:&nbsp;&nbsp;&nbsp;' . $vars['msg'];
    	$xPantalla .= '<br>';
    	$xPantalla .= 'Query:&nbsp;' . $vars['query'];
    	$xPantalla .= '<hr>';

    	if ($mostrar) {
    		echo $xPantalla;
    	} 

    	if ($registrar) {
    		$this->pQuery($query,$vars);
    	} 

    	if ($mail) {
    		$this->main->enviarCorreo('MySql - query error', 'Nuevo error: Revisar base de datos.');
    	}

    	return true;
	}

}

?>