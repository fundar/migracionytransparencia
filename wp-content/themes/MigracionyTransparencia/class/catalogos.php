<?php

/*incluir clase para manejra la BD*/
include_once "db/db.php";

class Catalogos {
	
	public function __construct() {
		/*configuración de base de datos*/
		include_once "config/database.php";
		
		/*conexion con base de datos*/
		$this->mysql = new Db();
		$this->mysql->connect($db);
	}
	
	/*categories*/
	public function categories() {
		$query = "select * from categories";
		$data  = $this->mysql->query($query);
		
		return $data;
	}
	
	/*dependencies*/
	public function dependencies() {
		$query = "select * from dependencies";
		$data  = $this->mysql->query($query);
		
		return $data;
	}
	
	/*organizations*/
	public function organizations() {
		$query = "select * from organizations";
		$data  = $this->mysql->query($query);
		
		return $data;
	}
	
	/*answersTypes*/
	public function answersTypes() {
		$query = "select * from answers_types";
		$data  = $this->mysql->query($query);
		
		return $data;
	}
	
	/*Select distinct years for requests*/
	public function years() {
		$query = "select distinct(year(date_published)) as year from requests order by year desc";
		$data  = $this->mysql->query($query);
		
		return $data;
	}
	
	public function fixed() {
		$query = "select * from requests where slug is NULL";
		$data  = $this->mysql->query($query);
		
		foreach($data as $value) {
			$slug  = slug($value["name"]);
			$query = "update requests set slug='$slug' where id_request=" . $value["id_request"];
			$data  = $this->mysql->query($query);
		}
		
		return $data;
	}
}
