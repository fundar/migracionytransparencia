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
	
	/*bucar solicitudes por slug*/
	public function getBySlug($slug) {		
		$query = "select requests.*, organizations.name as organization, dependencies.name as dependecy, categories.name as category from requests left join organizations on requests.id_organization=organizations.id_organization left join dependencies on requests.id_dependecy=dependencies.id_dependecy left join categories on categories.id_category=requests.id_category where requests.slug='" . $slug ."'";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*obtiene la respuesta de una solicitud*/
	public function getResponse($id_request) {
		$query = "select responses.*, answers_types.name as type_answer from responses left join answers_types on responses.id_type_answer=answers_types.id_type_answer where id_request=$id_request";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*obtiene la calidad de la respuesta de una solicitud*/
	public function getQualityResponse($id_response) {
		$query = "select * from quality where id_quality in (select id_quality from responses2quality where id_response=$id_response)";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data;
		else return false;
	}
}
