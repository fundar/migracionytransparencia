<?php
function getArray($text, $pos = NULL) {
	$text = ltrim($text, "{");
	$text = rtrim($text, "}");
	$data = explode(",", $text);

	if($pos !== NULL) {
		return $data[$pos];
	} else {
		return $data;
	}
}

function getTotalArray($text) {
	$text = ltrim($text, "{");
	$text = rtrim($text, "}");
	$data = explode(",", $text);
	
	return count($data);
}

/*obtiene la ruta de la url [array]*/
function getRoute($pos = false) {
	
	$route = explode("/", substr($_SERVER["REQUEST_URI"], 1));
	
	if($pos) {
		if(isset($route[$pos])) {
			return $route[$pos];
		} else {
			return false;
		}
	}
	
	return $route;
}

/*obtiene el slug de la url por GET*/
function getSlug() {
	if(isset($_GET["slug"])) {
		return $_GET["slug"];
	} else {
		return false;
	}
}

/*obtiene la url actual*/
function getURL(){
	$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $url;
}

/*funciones de fecha - obtiene el año*/
function getYear($date) {
	$explode = explode("-", $date);
	return $explode[0];
}

/*funciones de fecha - obtiene el mes*/
function getMonth($date) {
	$explode = explode("-", $date);
	return $explode[1];
}

/*funciones de fecha - obtiene el día*/
function getDay($date) {
	$explode = explode("-", $date);
	return $explode[2];
}

/*obtiene los limites offset de la pagina*/
function getOffset($limit) {
	if(isset($_GET["page"]) and is_numeric($_GET["page"])) {
		return $_GET["page"] * $limit - $limit;
	} else {
		return 0;
	}
}

/*obtiene el numero de paginas totales*/
function getPages($limit, $count) {
	return round($count/$limit);
}

/*obtiene la pgina actual*/
function getPage() {
	if(isset($_GET["page"]) and is_numeric($_GET["page"])) {
		return $_GET["page"];
	} else {
		return 1;
	}
}

/*genera un slug a partir de una cadena*/
function slug($string) {		
	$characters = array(
		"Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u", 
		"á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
		"à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u", "ã" => "a", "¿" => "", 
		"?" =>  "", "¡" =>  "", "!" =>  "", ": " => "-"
	);
	
	$string = strtr($string, $characters); 
	$string = strtolower(trim($string));
	$string = preg_replace("/[^a-z0-9-]/", "-", $string);
	$string = preg_replace("/-+/", "-", $string);

	
	if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
		$string = substr($string, 0, strlen($string) - 1);
	}
	
	return $string;
}

/*genera la cadena del query de busqueda*/
function isSearch() {
	if(isset($_GET["buscar"])) {
		
		/*values form*/
		$where = Array();
		$array = Array();
		$query = "";
		
		if(isset($_GET["search_query"]) and $_GET["search_query"] != "") {
			/*para buscar palabra por palabra*/
			$arraysearch_query = explode(" ", clean($_GET["search_query"]));
			$wherequery = "";
			foreach($arraysearch_query as $value) {
				$wherequery .= " or value like '%" . $value . "%'";
			}
			/*para buscar palabra por palabra - quitar la varialbe $wherequery del query*/
			
			$search_query  = "id_request in (select id_request from keywords2requests where id_keyword in (select id_keyword from keywords where ";
			$search_query .= "value like '%" . clean($_GET["search_query"]) ."%'" . $wherequery . "))";
			$where[0] = $search_query;
			$array[0] = clean($_GET["search_query"]);
		}
		
		if(isset($_GET["search_folio"]) and $_GET["search_folio"] != "") {
			$where[1] = "folio='" . clean($_GET["search_folio"]) ."'";
			$array[1] = clean($_GET["search_folio"]);
		}
		
		if(isset($_GET["category"]) and $_GET["category"] != "0") {
			$where[2] = "requests.id_category=" . clean($_GET["category"]);
			$array[2] = clean($_GET["category"]);
		}
		
		if(isset($_GET["dependency"]) and $_GET["dependency"] != "0") {
			$where[3] = "requests.id_dependecy=" . clean($_GET["dependency"]);
			$array[3] = clean($_GET["dependency"]);
		}
		
		if(isset($_GET["organization"]) and $_GET["organization"] != "0") {
			$where[4] = "requests.id_organization=" . clean($_GET["organization"]);
			$array[4] = clean($_GET["organization"]);
		}
		
		if(isset($_GET["answer_type"]) and $_GET["answer_type"] != "0") {
			$where[5] = "requests.id_request in (select id_request from responses where id_type_answer=" . clean($_GET["answer_type"]) . ")";
			$array[5] = clean($_GET["answer_type"]);
		}
		
		if(isset($_GET["ano"]) and $_GET["ano"] != "0") {
			$where[6] = "year(requests.date_published)=" . clean($_GET["ano"]);
			$array[6] = clean($_GET["ano"]);
		}
		
		$data["array"] = $array;
		
		if(count($where) > 0) {
			if(isset($where[0])) {
				$query .= "where " . $where[0];
				
				if(isset($where[1])) {
					$query .= " or " . $where[1];
					unset($where[1]);
				}
				
				unset($where[0]);
				
				foreach($where as $wher) {
					$query .= " and " . $wher;
				}
			} elseif(isset($where[1])) {
				$query .= "where " . $where[1];
				
				unset($where[1]);
				foreach($where as $wher) {
					$query .= " and " . $wher;
				}
			} else {
				$i=0;
				
				foreach($where as $wher) {
					if($i==0) $query .= "where " . $wher;
					else $query .= " and " . $wher;
					
					$i++;
				}
			}
			
			$data["query"] = $query;
			
			return $data;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/*limpia un string*/
function clean($string) {
	$string = str_replace("'", "", $string);
	$string = str_replace("\'", "", $string);
	$string = str_replace("''", "", $string);
	
	return utf8_decode($string);
}

/*comprueba si hay erroe en la url*/
function isError() {
	$route = getRoute();
	
	if(is_array($route) and $route[0] == "?error=not-found") return true;
	else return false;
}
