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
	
	/*Genera el html para la numeralia*/
	public function getNumeralia() {
		$count = $this->countRequests();
		$inm   = $this->countDepedency();
		$incom = $this->countAnswerType();
		
		$html = '<div class="shot" style="display: block;">';
			$html .= '<p class="dato">' . $inm . '</p>';
			$html .= '<div class="numeralia-info">';
				$html .= '<p>La base de datos contiene ' . $count . ' solicitudes, de las cuales ' . $inm . ' fueron dirigidas al Instituto Nacional de Migración.</p>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="divisor-1"></div>';

		$html .= '<div class="shot" style="display: block;">';
			$html .= '<p class="dato">' . $incom . '</p>';
			$html .= '<div class="numeralia-info">';
				$html .= '<p>En ' . $incom . ' de las ' . $count . ' solicitudes de acceso a información, la respuesta que brinda la dependencia es incompleta.</p>';
			$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="divisor-1"></div>';
		
		return $html;
	}
	
	/* Total de solicitudes */
	public function countRequests() {
		$query = "select count(*) as total from requests";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0]["total"];
		else return 0;
	}
	
	/* Total de solicitudes por dependecia - default: "INSTITUTO NACIONAL DE MIGRACIÓN" - 189 */
	public function countDepedency($id_dependecy = 189) {
		$query = "select count(*) as total from requests where id_dependecy=$id_dependecy";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0]["total"];
		else return 0;
	}
	
	/* Total de respuestas por tipo de respuesta - default: "Incompleta" - 4 */
	public function countAnswerType($id_type_answer = 4) {
		$query = "select count(*) as total from responses where id_response in (select id_response from responses2quality where id_quality=$id_type_answer)";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0]["total"];
		else return 0;
	}
	
	/*
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
	*/
}
