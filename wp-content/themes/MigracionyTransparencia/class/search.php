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
		$query = "select requests.* from requests " . $queryString . " order by requests.date_published desc";
		$data  = $this->mysql->query($query);
		die(var_dump($query));
		
		if($data and is_array($data)) return $data;
		else return false;
	}
	
	/*Cuenta las solicitudes por query de busqueda*/
	public function countByQuery($queryString) {
		$query = "select count(*) as total from requests " . $queryString . " order by requests.date_published desc";
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
	
	/*categories*/
	public function category($id_category) {
		$query = "select * from categories where id_category=$id_category";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*dependencies*/
	public function dependency($id_dependency) {
		$query = "select * from dependencies where id_dependecy=$id_dependecy";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*organizations*/
	public function organization($id_organization) {
		$query = "select * from organizations where id_organization=$id_organization";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*answersTypes*/
	public function answersType($id_type_answer) {
		$query = "select * from answers_types where id_type_answer=$id_type_answer";
		$data  = $this->mysql->query($query);
		
		if($data and is_array($data)) return $data[0];
		else return false;
	}
	
	/*recorre el arry para obtener los criterios de busqueda*/
	public function getCriterios($array = false) {
		if(is_array($array)) {
			$string = "";
			
			foreach($array as $key => $value) {
				if($key==0) $string .= "Por la palabra: <strong>" . $value . "</strong><br/>";
				if($key==1) $string .= "Por el folio: <strong>"   . $value . "</strong><br/>";
				
				if($key==2)  {
					$data = $this->category($value);
					$string .= "Que contenga la categoría: <strong>"   . utf8_encode($data["name"]) . "</strong><br/>";
				}
				if($key==3)  {
					$data = $this->dependency($value);
					$string .= "De la dependencia: <strong>"   . utf8_encode($data["name"]) . "</strong><br/>";
				}
				if($key==4)  {
					$data = $this->organization($value);
					$string .= "De la organización: <strong>"   . utf8_encode($data["name"]) . "</strong><br/>";
				}
				if($key==5)  {
					$data = $this->answersType($value);
					$string .= "Que el tipo de respuesta sea: <strong>"   . utf8_encode($data["name"]) . "</strong><br/>";
				}
				
				if($key==6) $string .= "Del año: <strong>"   . $value . "</strong><br/>";
			}
			
			return $string;
		} else {
			return false;
		}
	}
}
