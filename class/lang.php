<?php
class lang {

	// Lo difinido en $_SESSION['lang'], va a ser usado como parte del path donde se guardan
	// los templates en los diferentes idiomas.

	protected $path;

	public function __construct() {
		$this->path = INSTALLPATH;
	}

	function es() {
		@session_start();
		$_SESSION['lang'] = 'es/';
		header('location:'.$this->path);
	}

	function en() {
		@session_start();
		$_SESSION['lang'] = 'en/';
		header('location:'.$this->path);
	}

	function pr() {
		@session_start();
		$_SESSION['lang'] = 'pr/';
		header('location:'.$this->path);
	}
}
?>
