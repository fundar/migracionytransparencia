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
	
	/*obtiene todas las solicitudes*/
	public function all($limit, $offset) {
		$query = "select requests.*, organizations.name as organization, dependencies.name as dependecy, categories.name as category from requests left join organizations on requests.id_organization=organizations.id_organization left join dependencies on requests.id_dependecy=dependencies.id_dependecy left join categories on categories.id_category=requests.id_category order by requests.date_published desc limit $limit offset $offset";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data;
		else return false;
	}
	
	/*busca las solicitudes por query de busqueda*/
	public function byQuery($queryString) {
		$query = "select requests.*, organizations.name as organization, dependencies.name as dependecy, categories.name as category from requests left join organizations on requests.id_organization=organizations.id_organization left join dependencies on requests.id_dependecy=dependencies.id_dependecy left join categories on categories.id_category=requests.id_category " . $queryString . " order by requests.date_published desc";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data;
		else return false;
	}
	
	/*Cuenta las solicitudes por query de busqueda*/
	public function countByQuery($queryString) {
		$query = "select count(*) as total from requests left join organizations on requests.id_organization=organizations.id_organization left join dependencies on requests.id_dependecy=dependencies.id_dependecy left join categories on categories.id_category=requests.id_category " . $queryString . " order by requests.date_published desc";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0]["total"];
		else return 0;
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
	
	/*obtiene la calidad de la respuesta de una respuesta*/
	public function getQualityResponse($id_response) {
		$query = "select * from quality where id_quality in (select id_quality from responses2quality where id_response=$id_response)";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data;
		else return false;
	}
	
	/*obtiene los tipos de documentos de una respuesta*/
	public function getDocumentsTypeResponse($id_response) {
		$query = "select * from documents_types where id_type_document in (select id_type_document from responses2documentstypes where id_response=$id_response)";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data;
		else return false;
	}
	
	/*obtiene el recurso de revisión de la solitud*/
	public function getReview($id_request) {
		$query = "select * from reviews where id_request=$id_request";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*obtiene los actos que se recurrieron de un recurso de revisión*/
	public function getActsReviews($id_review) {
		$query = "select * from turn_acts where id_act in (select id_act from acts2reviews where id_review=$id_review)";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data;
		else return false;
	}
	
	/*obtiene la resolución de una solicitud*/
	public function getResolution($id_request) {
		$query = "select * from resolutions where id_request=$id_request";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*obtiene el cumplimineto de una solicitud*/
	public function getCumplimiento($id_request) {
		$query = "select * from cumplimiento where id_request=$id_request";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*total de registros*/
	public function countAll() {
		$query = "select count(*) as total from requests";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0]["total"];
		else return false;
	}
}
