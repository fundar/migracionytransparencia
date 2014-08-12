<?php

/*incluir clase para manejra la BD*/
include_once "db/db.php";

class Search {
	
	public function __construct() {
		/*configuración de base de datos*/
		include_once "config/database.php";
		
		/*conexion con base de datos*/
		$this->mysql = new Db();
		$this->mysql->connect($db);
	}
	
	/*test method*/
	public function example() {
		/*query*/
		$query = "select * from requests";
		$data  = $this->mysql->query($query);
		
		die(var_dump($data));
	}
}
